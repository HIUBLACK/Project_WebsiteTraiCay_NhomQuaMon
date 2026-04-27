<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    private function getProductForOrder(int $productId)
    {
        return DB::table('tbl_product')
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->lockForUpdate()
            ->first();
    }

    private function syncProductStatusAfterStockChange(int $productId)
    {
        $product = DB::table('tbl_product')->where('product_id', $productId)->first();

        if (!$product) {
            return;
        }

        $nextStatus = (int) $product->product_status;

        if ((int) $product->stock_quantity <= 0) {
            $nextStatus = 0;
        } elseif ((int) $product->stock_quantity > 0 && (int) $product->product_status === 0) {
            $nextStatus = 1;
        }

        if ($nextStatus !== (int) $product->product_status) {
            DB::table('tbl_product')->where('product_id', $productId)->update([
                'product_status' => $nextStatus,
                'updated_at' => now(),
            ]);
        }
    }

    private function validateCheckoutStock($cart)
    {
        foreach ($cart as $item) {
            $product = DB::table('tbl_product')
                ->where('product_id', $item->oder_id_product)
                ->whereNull('deleted_at')
                ->first();

            if (!$product || (int) $product->product_status !== 1 || (int) $product->stock_quantity <= 0) {
                return 'Có sản phẩm trong giỏ hiện không khả dụng';
            }

            if ((int) $item->oder_soluong > (int) $product->stock_quantity) {
                return 'Số lượng sản phẩm quá số tồn kho';
            }
        }

        return null;
    }

    private function restoreStockForOrder(int $orderId)
    {
        $items = DB::table('tbl_oder')->where('order_id', $orderId)->get();

        foreach ($items as $item) {
            DB::table('tbl_product')
                ->where('product_id', $item->oder_id_product)
                ->increment('stock_quantity', $item->oder_soluong);

            $this->syncProductStatusAfterStockChange((int) $item->oder_id_product);
        }
    }

    private function markVnpayOrderFailed(int $orderId)
    {
        DB::transaction(function () use ($orderId) {
            $order = DB::table('tbl_order_main')->where('order_id', $orderId)->lockForUpdate()->first();

            if (!$order || (int) $order->status === 5) {
                return;
            }

            DB::table('tbl_order_main')->where('order_id', $orderId)->update([
                'status' => 5,
                'payment_status' => 2,
                'cancel_reason' => 'Thanh toán VNPAY thất bại hoặc bị hủy',
                'cancelled_at' => now(),
            ]);

            DB::table('tbl_oder')->where('order_id', $orderId)->update([
                'oder_status' => 5,
                'updated_at' => now(),
            ]);

            $this->restoreStockForOrder($orderId);
        });
    }

    private function getVnpayConfig()
    {
        return [
            'url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
            'return_url' => url('/vnpay-return'),
            'tmn_code' => 'HTA3TRAF',
            'hash_secret' => '0C2OZPME1GF7OBX2UKPQU89758M570UP',
        ];
    }

    private function couponIsSingleUsePerUser($coupon)
    {
        return isset($coupon->coupon_user_usage_mode) && (int) $coupon->coupon_user_usage_mode === 1;
    }

    private function couponAppliesToUser($couponId, $user)
    {
        $userList = DB::table('tbl_coupon_user')
            ->where('coupon_id', $couponId)
            ->pluck('user_id')
            ->toArray();

        if (count($userList) > 0 && !in_array($user->id, $userList)) {
            return false;
        }

        $rankList = DB::table('tbl_coupon_rank')
            ->where('coupon_id', $couponId)
            ->pluck('rank')
            ->toArray();

        if (count($rankList) > 0 && !in_array($user->rank, $rankList)) {
            return false;
        }

        return true;
    }

    private function couponAppliesToProduct($coupon, $productId)
    {
        if ((int) $coupon->coupon_scope !== 2) {
            return true;
        }

        return DB::table('tbl_coupon_product')
            ->where('coupon_id', $coupon->coupon_id)
            ->where('product_id', $productId)
            ->exists();
    }

    private function getCheckoutCart(int $userId)
    {
        return DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->where('tbl_oder.oder_status', 2)
            ->where('tbl_oder.oder_id_user', $userId)
            ->select(
                'tbl_oder.*',
                'tbl_product.product_name',
                'tbl_product.product_price',
                'tbl_product.product_image',
                'tbl_product.stock_quantity',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();
    }

    private function calculateCouponDiscount($coupon, $cart, $user)
    {
        if (!$coupon || !$user || !$this->couponAppliesToUser($coupon->coupon_id, $user)) {
            return 0;
        }

        $discount = 0;
        foreach ($cart as $item) {
            if (!$this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                continue;
            }

            if ((int) $coupon->coupon_type === 1) {
                $discount += ($item->product_price * $item->oder_soluong * $coupon->coupon_value) / 100;
            } else {
                $discount += $coupon->coupon_value;
            }
        }

        return (int) $discount;
    }

    private function validateCouponForCheckout($coupon, $user, $cart)
    {
        if (!$coupon || !$user || $cart->isEmpty()) {
            return false;
        }

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry)) {
            return false;
        }

        if ($coupon->coupon_usage_limit > 0 && $coupon->coupon_used_count >= $coupon->coupon_usage_limit) {
            return false;
        }

        if ($this->couponIsSingleUsePerUser($coupon)) {
            $used = DB::table('tbl_coupon_usage')
                ->where('coupon_id', $coupon->coupon_id)
                ->where('user_id', $user->id)
                ->exists();

            if ($used) {
                return false;
            }
        }

        if (!$this->couponAppliesToUser($coupon->coupon_id, $user)) {
            return false;
        }

        $hasApplicableProduct = false;
        $total = 0;
        $quantity = 0;

        foreach ($cart as $item) {
            $total += $item->product_price * $item->oder_soluong;
            $quantity += $item->oder_soluong;

            if ($this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                $hasApplicableProduct = true;
            }
        }

        if ((int) $coupon->coupon_scope === 2 && !$hasApplicableProduct) {
            return false;
        }

        $cond = DB::table('tbl_coupon_conditions')
            ->where('coupon_id', $coupon->coupon_id)
            ->first();

        if ($cond) {
            if ($cond->min_order_value && $total < $cond->min_order_value) {
                return false;
            }

            if ($cond->min_order_quantity && $quantity < $cond->min_order_quantity) {
                return false;
            }
        }

        return true;
    }

    private function getCheckoutSummary(int $userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();
        $cart = $this->getCheckoutCart($userId);
        $total = $cart->sum(function ($item) {
            return $item->product_price * $item->oder_soluong;
        });

        $coupon = Session::get('coupon');
        $discount = 0;

        if ($coupon && $this->validateCouponForCheckout($coupon, $user, $cart)) {
            $discount = $this->calculateCouponDiscount($coupon, $cart, $user);
        } elseif ($coupon) {
            Session::forget('coupon');
            $coupon = null;
        }

        return [
            'user' => $user,
            'cart' => $cart,
            'coupon' => $coupon,
            'total' => (int) $total,
            'discount' => (int) $discount,
            'total_after' => max(0, (int) $total - (int) $discount),
        ];
    }

    private function updateUserRankAndSpent($userId, $totalAfter)
    {
        DB::table('users')->where('id', $userId)->increment('total_spent', $totalAfter);

        $tongTien = DB::table('users')->where('id', $userId)->value('total_spent');
        $rank = 'Thường';

        if ($tongTien >= 10000000) {
            $rank = 'Kim cương';
        } elseif ($tongTien >= 5000000) {
            $rank = 'Vàng';
        } elseif ($tongTien >= 1000000) {
            $rank = 'Bạc';
        }

        DB::table('users')->where('id', $userId)->update(['rank' => $rank]);
    }

    private function finalizeCouponUsage($coupon, $userId)
    {
        if (!$coupon) {
            return;
        }

        DB::table('tbl_coupon')
            ->where('coupon_id', $coupon->coupon_id)
            ->increment('coupon_used_count');

        if ($this->couponIsSingleUsePerUser($coupon)) {
            $exists = DB::table('tbl_coupon_usage')
                ->where('coupon_id', $coupon->coupon_id)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                DB::table('tbl_coupon_usage')->insert([
                    'coupon_id' => $coupon->coupon_id,
                    'user_id' => $userId,
                    'created_at' => now(),
                ]);
            }
        }
    }

    private function finalizeOrderSuccess(array $pendingData)
    {
        if (!empty($pendingData['effects_finalized'])) {
            return;
        }

        $this->updateUserRankAndSpent($pendingData['user_id'], $pendingData['total_after']);

        if (!empty($pendingData['coupon'])) {
            $this->finalizeCouponUsage((object) $pendingData['coupon'], $pendingData['user_id']);
        }
    }

    private function createOrderRecord($userId, array $shippingData, array $summary, string $paymentMethod, int $paymentStatus)
    {
        return DB::transaction(function () use ($userId, $shippingData, $summary, $paymentMethod, $paymentStatus) {
            foreach ($summary['cart'] as $item) {
                $product = $this->getProductForOrder((int) $item->oder_id_product);

                if (!$product || (int) $product->product_status !== 1 || (int) $product->stock_quantity <= 0) {
                    throw new \RuntimeException('Có sản phẩm trong giỏ hiện không khả dụng');
                }

                if ((int) $item->oder_soluong > (int) $product->stock_quantity) {
                    throw new \RuntimeException('Số lượng sản phẩm quá số tồn kho');
                }
            }

            $orderId = DB::table('tbl_order_main')->insertGetId([
                'user_id' => $userId,
                'name' => $shippingData['name'],
                'address' => $shippingData['address'],
                'phone' => $shippingData['phone'],
                'total' => $summary['total_after'],
                'payment_method' => $paymentMethod,
                'status' => 0,
                'payment_status' => $paymentStatus,
                'coupon_code' => $summary['coupon'] ? $summary['coupon']->coupon_code : null,
                'coupon_discount' => $summary['discount'],
                'created_at' => now(),
            ]);

            foreach ($summary['cart'] as $item) {
                DB::table('tbl_oder')
                    ->where('oder_id', $item->oder_id)
                    ->where('oder_status', 2)
                    ->update([
                        'order_id' => $orderId,
                        'oder_status' => 0,
                        'updated_at' => now(),
                    ]);

                DB::table('tbl_product')
                    ->where('product_id', $item->oder_id_product)
                    ->decrement('stock_quantity', $item->oder_soluong);

                $this->syncProductStatusAfterStockChange((int) $item->oder_id_product);
            }

            return $orderId;
        });
    }

    private function buildVnpayUrl($orderId, $amount)
    {
        $config = $this->getVnpayConfig();
        $txnRef = 'ORDER_' . $orderId . '_' . time();

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $config['tmn_code'],
            'vnp_Amount' => (int) $amount * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => request()->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang #' . $orderId,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $config['return_url'],
            'vnp_TxnRef' => $txnRef,
        ];

        ksort($inputData);

        $query = [];
        $hashData = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . '=' . urlencode($value);
            $hashData[] = urlencode($key) . '=' . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', implode('&', $hashData), $config['hash_secret']);

        return $config['url'] . '?' . implode('&', $query) . '&vnp_SecureHash=' . $secureHash;
    }

    private function verifyVnpayReturn(Request $request)
    {
        $config = $this->getVnpayConfig();
        $inputData = $request->except('vnp_SecureHash', 'vnp_SecureHashType');

        ksort($inputData);

        $hashData = [];
        foreach ($inputData as $key => $value) {
            $hashData[] = urlencode($key) . '=' . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', implode('&', $hashData), $config['hash_secret']);

        return hash_equals($secureHash, (string) $request->vnp_SecureHash);
    }

    public function thanh_toan()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $summary = $this->getCheckoutSummary(Auth::id());
        if ($summary['cart']->isEmpty()) {
            return redirect('/gio-hang')->with('message', 'Giỏ hàng trống');
        }

        $stockError = $this->validateCheckoutStock($summary['cart']);
        if ($stockError) {
            return redirect('/gio-hang')->with('error', $stockError);
        }

        return view('pages.checkout', [
            'all_oder' => $summary['cart'],
            'total' => $summary['total'],
            'discount' => $summary['discount'],
            'total_after' => $summary['total_after'],
        ]);
    }

    public function xu_ly_thanh_toan(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $request->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:5',
            'phone' => 'required',
            'payment_method' => 'required|in:cod,vnpay',
        ]);

        $userId = Auth::id();
        $summary = $this->getCheckoutSummary($userId);

        if ($summary['cart']->isEmpty()) {
            return redirect('/gio-hang')->with('message', 'Giỏ hàng trống');
        }

        $stockError = $this->validateCheckoutStock($summary['cart']);
        if ($stockError) {
            return redirect('/gio-hang')->with('error', $stockError);
        }

        $shippingData = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        if ($request->payment_method === 'cod') {
            try {
                $this->createOrderRecord($userId, $shippingData, $summary, 'cod', 0);
            } catch (\RuntimeException $exception) {
                return redirect('/gio-hang')->with('error', $exception->getMessage());
            }

            $this->updateUserRankAndSpent($userId, $summary['total_after']);
            $this->finalizeCouponUsage($summary['coupon'], $userId);
            Session::forget('coupon');

            return redirect('/lich-su-dat-hang')->with('message', 'Đặt hàng COD thành công');
        }

        try {
            $orderId = $this->createOrderRecord($userId, $shippingData, $summary, 'vnpay', 0);
        } catch (\RuntimeException $exception) {
            return redirect('/gio-hang')->with('error', $exception->getMessage());
        }

        Session::put('pending_vnpay_checkout', [
            'order_id' => $orderId,
            'user_id' => $userId,
            'total_after' => $summary['total_after'],
            'coupon' => $summary['coupon'] ? (array) $summary['coupon'] : null,
            'effects_finalized' => false,
        ]);

        return redirect($this->buildVnpayUrl($orderId, $summary['total_after']));
    }

    public function vnpay_return(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $pending = Session::get('pending_vnpay_checkout');
        if (!$pending || (int) $pending['user_id'] !== (int) Auth::id()) {
            return redirect('/lich-su-dat-hang')->with('message', 'Không tìm thấy phiên thanh toán VNPAY');
        }

        $order = DB::table('tbl_order_main')
            ->where('order_id', $pending['order_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            Session::forget('pending_vnpay_checkout');
            return redirect('/lich-su-dat-hang')->with('message', 'Không tìm thấy đơn hàng VNPAY');
        }

        if (!$this->verifyVnpayReturn($request)) {
            $this->markVnpayOrderFailed((int) $order->order_id);
            Session::forget('coupon');
            Session::forget('pending_vnpay_checkout');

            return redirect('/lich-su-dat-hang')->with('message', 'Chữ ký VNPAY không hợp lệ');
        }

        if ($request->vnp_ResponseCode === '00' && $request->vnp_TransactionStatus === '00') {
            $paidAmount = ((int) $request->vnp_Amount) / 100;

            if ((int) $paidAmount !== (int) $order->total) {
                $this->markVnpayOrderFailed((int) $order->order_id);
                Session::forget('coupon');
                Session::forget('pending_vnpay_checkout');

                return redirect('/lich-su-dat-hang')->with('message', 'Số tiền thanh toán không khớp');
            }

            DB::table('tbl_order_main')->where('order_id', $order->order_id)->update([
                'payment_status' => 1,
                'status' => 0,
            ]);

            DB::table('tbl_oder')->where('order_id', $order->order_id)->update([
                'oder_status' => 0,
                'updated_at' => now(),
            ]);

            $this->finalizeOrderSuccess($pending);
            Session::forget('coupon');
            Session::forget('pending_vnpay_checkout');

            return redirect('/lich-su-dat-hang')->with('message', 'Thanh toán VNPAY thành công');
        }

        $this->markVnpayOrderFailed((int) $order->order_id);

        Session::forget('coupon');
        Session::forget('pending_vnpay_checkout');

        return redirect('/lich-su-dat-hang')->with('message', 'Thanh toán VNPAY thất bại hoặc bị hủy');
    }

    public function apply_coupon(Request $request)
    {
        $coupon = DB::table('tbl_coupon')
            ->where('coupon_code', $request->coupon_code)
            ->first();

        if (!$coupon) {
            return back()->with('message', 'Sai mã');
        }

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry)) {
            return back()->with('message', 'Hết hạn');
        }

        if ($coupon->coupon_usage_limit > 0 && $coupon->coupon_used_count >= $coupon->coupon_usage_limit) {
            return back()->with('message', 'Hết lượt');
        }

        $userId = Auth::id();
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return back()->with('message', 'Không tìm thấy user');
        }

        $cart = $this->getCheckoutCart($userId);
        if (!$this->validateCouponForCheckout($coupon, $user, $cart)) {
            Session::forget('coupon');
            return back()->with('message', 'Mã giảm giá không áp dụng cho giỏ hàng hiện tại');
        }

        Session::put('coupon', $coupon);
        return back()->with('message', 'Đã áp dụng mã giảm giá');
    }

    public function remove_coupon($coupon_id)
    {
        if (!Session::has('coupon')) {
            return back()->with('message', 'Chưa có mã giảm giá để xóa');
        }

        $coupon = Session::get('coupon');
        if ((int) $coupon->coupon_id !== (int) $coupon_id) {
            return back()->with('message', 'Mã giảm giá không hợp lệ');
        }

        Session::forget('coupon');
        return back()->with('message', 'Đã gỡ mã giảm giá');
    }
}
