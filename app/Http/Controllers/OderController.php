<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OderController extends Controller
{
    private function syncProductStatusAfterStockRestore(int $productId)
    {
        $product = DB::table('tbl_product')->where('product_id', $productId)->first();

        if ($product && (int) $product->stock_quantity > 0 && (int) $product->product_status === 0) {
            DB::table('tbl_product')->where('product_id', $productId)->update([
                'product_status' => 1,
                'updated_at' => now(),
            ]);
        }
    }

    private function restoreOrderStock(int $orderId)
    {
        $items = DB::table('tbl_oder')
            ->where('order_id', $orderId)
            ->get();

        foreach ($items as $item) {
            DB::table('tbl_product')
                ->where('product_id', $item->oder_id_product)
                ->increment('stock_quantity', $item->oder_soluong);

            $this->syncProductStatusAfterStockRestore((int) $item->oder_id_product);
        }
    }

    private function orderStatusLabels()
    {
        return [
            0 => 'Chờ xác nhận',
            1 => 'Đã xác nhận',
            2 => 'Đang chuẩn bị',
            3 => 'Đang giao',
            4 => 'Đã giao',
            5 => 'Đã hủy',
        ];
    }

    private function paymentStatusLabels()
    {
        return [
            0 => 'Chưa thanh toán',
            1 => 'Đã thanh toán',
            2 => 'Thanh toán thất bại',
            3 => 'Đã hoàn tiền',
        ];
    }

    private function allowedTransitions()
    {
        return [
            0 => [1, 5],
            1 => [2, 5],
            2 => [3],
            3 => [4],
            4 => [],
            5 => [],
        ];
    }

    private function getAllowedTargetStatuses(int $status)
    {
        return $this->allowedTransitions()[$status] ?? [];
    }

    private function canCancelOrder(int $status)
    {
        return in_array($status, [0, 1], true);
    }

    private function updateOrderAndItemsStatus(int $orderId, int $status)
    {
        DB::transaction(function () use ($orderId, $status) {
            $order = DB::table('tbl_order_main')->where('order_id', $orderId)->first();

            $updateData = [
                'status' => $status,
            ];

            if ($order && $status === 4 && $order->payment_method === 'cod' && (int) $order->payment_status === 0) {
                $updateData['payment_status'] = 1;
            }

            DB::table('tbl_order_main')
                ->where('order_id', $orderId)
                ->update($updateData);

            DB::table('tbl_oder')
                ->where('order_id', $orderId)
                ->update([
                    'oder_status' => $status,
                    'updated_at' => now(),
                ]);
        });
    }

    private function cancelOrderRecord($order, string $reason)
    {
        if (!$this->canCancelOrder((int) $order->status)) {
            return 'Đơn hàng không thể hủy ở trạng thái hiện tại';
        }

        if (trim($reason) === '') {
            return 'Vui lòng nhập lý do hủy';
        }

        DB::transaction(function () use ($order, $reason) {
            $updateData = [
                'status' => 5,
                'cancel_reason' => $reason,
                'cancelled_at' => now(),
            ];

            if ((int) $order->payment_status === 1) {
                $updateData['payment_status'] = 3;
            }

            DB::table('tbl_order_main')
                ->where('order_id', $order->order_id)
                ->update($updateData);

            DB::table('tbl_oder')
                ->where('order_id', $order->order_id)
                ->update([
                    'oder_status' => 5,
                    'updated_at' => now(),
                ]);

            $this->restoreOrderStock((int) $order->order_id);
        });

        return null;
    }

    private function getOrderForUser($orderId, $userId)
    {
        return DB::table('tbl_order_main')
            ->where('order_id', $orderId)
            ->where('user_id', $userId)
            ->first();
    }

    private function getOrderDetailPayload($orderId)
    {
        $order = DB::table('tbl_order_main')
            ->leftJoin('users', 'tbl_order_main.user_id', '=', 'users.id')
            ->where('tbl_order_main.order_id', $orderId)
            ->select(
                'tbl_order_main.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->first();

        if (!$order) {
            return null;
        }

        $items = DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->where('tbl_oder.order_id', $orderId)
            ->select(
                'tbl_oder.oder_id',
                'tbl_oder.oder_id_product as product_id',
                'tbl_oder.oder_soluong',
                'tbl_oder.oder_status',
                'tbl_product.product_name',
                'tbl_product.product_image',
                'tbl_product.product_price',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();

        return [
            'order' => $order,
            'items' => $items,
            'orderStatusLabels' => $this->orderStatusLabels(),
            'paymentStatusLabels' => $this->paymentStatusLabels(),
            'allowedStatuses' => $this->getAllowedTargetStatuses((int) $order->status),
        ];
    }

    public function all_oder(Request $request)
    {
        $query = DB::table('tbl_order_main')
            ->leftJoin('users', 'tbl_order_main.user_id', '=', 'users.id')
            ->leftJoin('tbl_oder', 'tbl_order_main.order_id', '=', 'tbl_oder.order_id')
            ->select(
                'tbl_order_main.*',
                'users.name as user_name',
                'users.email as user_email',
                DB::raw('COALESCE(SUM(tbl_oder.oder_soluong), 0) as total_quantity')
            );

        if ($request->filled('status')) {
            $query->where('tbl_order_main.status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('tbl_order_main.payment_status', $request->payment_status);
        }

        if ($request->filled('date')) {
            $query->whereDate('tbl_order_main.created_at', $request->date);
        }

        $orders = $query
            ->groupBy(
                'tbl_order_main.order_id',
                'tbl_order_main.user_id',
                'tbl_order_main.name',
                'tbl_order_main.address',
                'tbl_order_main.phone',
                'tbl_order_main.total',
                'tbl_order_main.payment_method',
                'tbl_order_main.created_at',
                'tbl_order_main.status',
                'tbl_order_main.payment_status',
                'tbl_order_main.coupon_code',
                'tbl_order_main.coupon_discount',
                'tbl_order_main.cancel_reason',
                'tbl_order_main.cancelled_at',
                'users.name',
                'users.email'
            )
            ->orderByDesc('tbl_order_main.order_id')
            ->get();

        return view('pages_admin.all_oder', [
            'orders' => $orders,
            'orderStatusLabels' => $this->orderStatusLabels(),
            'paymentStatusLabels' => $this->paymentStatusLabels(),
            'filters' => [
                'status' => $request->status,
                'payment_status' => $request->payment_status,
                'date' => $request->date,
            ],
        ]);
    }

    public function show_oder($orderId)
    {
        $payload = $this->getOrderDetailPayload($orderId);
        if (!$payload) {
            return redirect('/all-oder')->with('message', 'Không tìm thấy đơn hàng');
        }

        return view('pages_admin.admin_order_detail', $payload);
    }

    public function update_order_status(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:5',
            'cancel_reason' => 'nullable|string|max:1000',
        ]);

        $order = DB::table('tbl_order_main')->where('order_id', $orderId)->first();
        if (!$order) {
            return redirect('/all-oder')->with('message', 'Không tìm thấy đơn hàng');
        }

        $targetStatus = (int) $request->status;
        $allowed = $this->getAllowedTargetStatuses((int) $order->status);

        if (!in_array($targetStatus, $allowed, true)) {
            return redirect('/all-oder')->with('message', 'Không thể chuyển trạng thái đơn hàng theo cách này');
        }

        if ($targetStatus === 5) {
            $error = $this->cancelOrderRecord($order, (string) $request->cancel_reason);
            if ($error) {
                return redirect('/all-oder')->with('message', $error);
            }

            $message = (int) $order->payment_status === 1
                ? 'Đã hủy đơn và hệ thống đang xử lý hoàn tiền'
                : 'Đã hủy đơn hàng';

            return redirect('/all-oder')->with('message', $message);
        }

        $this->updateOrderAndItemsStatus($orderId, $targetStatus);

        return redirect('/all-oder')->with('message', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function detail_oder()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập để xem đơn hàng');
        }

        $orders = DB::table('tbl_order_main')
            ->where('user_id', Auth::id())
            ->orderByDesc('order_id')
            ->get();

        return view('pages.oder_history', [
            'orders' => $orders,
            'orderStatusLabels' => $this->orderStatusLabels(),
            'paymentStatusLabels' => $this->paymentStatusLabels(),
        ]);
    }

    public function chi_tiet_don($orderId)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập');
        }

        $payload = $this->getOrderDetailPayload($orderId);
        if (!$payload || (int) $payload['order']->user_id !== (int) Auth::id()) {
            return redirect('/lich-su-dat-hang')->with('message', 'Không tìm thấy đơn hàng');
        }

        $existingReviews = DB::table('tbl_reviews')
            ->where('order_id', $payload['order']->order_id)
            ->where('user_id', Auth::id())
            ->pluck('review_id', 'product_id');

        $canReviewOrder = (int) $payload['order']->status === 4 && (int) $payload['order']->payment_status === 1;

        $payload['items'] = $payload['items']->map(function ($item) use ($existingReviews, $payload, $canReviewOrder) {
            $reviewId = $existingReviews[$item->product_id] ?? null;
            $item->review_id = $reviewId;
            $item->has_review = $reviewId !== null;
            $item->can_review = $canReviewOrder && !$item->has_review;
            $item->review_url = url('/chi-tiet-san-pham/' . $item->product_id . '?review_order_id=' . $payload['order']->order_id . '#review-form');

            return $item;
        });

        return view('pages.order_detail', $payload);
    }

    public function huy_don(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập');
        }

        $order = $this->getOrderForUser($orderId, Auth::id());
        if (!$order) {
            return redirect('/lich-su-dat-hang')->with('message', 'Không tìm thấy đơn hàng');
        }

        $error = $this->cancelOrderRecord($order, (string) $request->cancel_reason);
        if ($error) {
            return redirect('/lich-su-dat-hang')->with('message', $error);
        }

        $message = (int) $order->payment_status === 1
            ? 'Đã hủy đơn và hệ thống đang xử lý hoàn tiền'
            : 'Đã hủy đơn hàng';

        return redirect('/lich-su-dat-hang')->with('message', $message);
    }
}
