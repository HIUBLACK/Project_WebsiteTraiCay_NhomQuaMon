<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Lấy tất cả đơn hàng (admin)
     */
    public function getAllOrders(): \Illuminate\Support\Collection
    {
        return DB::table('tbl_oder')
            ->where('oder_status', '!=', 2)
            ->orderByDesc('oder_id')
            ->get();
    }

    /**
     * Lấy đơn hàng theo user
     */
    public function getOrdersByUser(int $userId): \Illuminate\Support\Collection
    {
        return DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->where('tbl_oder.oder_status', '!=', 2)
            ->where('tbl_oder.oder_id_user', $userId)
            ->select(
                'tbl_oder.*',
                'tbl_product.product_name',
                'tbl_product.product_price',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();
    }

    /**
     * Duyệt đơn hàng (status 0 → 1)
     */
    public function approveOrder(int $oderId): bool
    {
        $oder = DB::table('tbl_oder')->where('oder_id', $oderId)->first();

        if (!$oder) {
            throw new \RuntimeException('Đơn hàng không tồn tại.');
        }

        if ($oder->oder_status === 1) {
            throw new \RuntimeException('Đơn hàng đã được duyệt rồi.');
        }

        if ($oder->oder_status === 2) {
            throw new \RuntimeException('Không thể duyệt đơn hàng đang trong giỏ hàng.');
        }

        DB::table('tbl_oder')->where('oder_id', $oderId)->update([
            'oder_status' => 1,
            'updated_at'  => now(),
        ]);

        return true;
    }

    /**
     * Hủy duyệt đơn hàng (status 1 → 0)
     */
    public function cancelApproval(int $oderId): bool
    {
        $oder = DB::table('tbl_oder')->where('oder_id', $oderId)->first();

        if (!$oder) {
            throw new \RuntimeException('Đơn hàng không tồn tại.');
        }

        if ($oder->oder_status !== 1) {
            throw new \RuntimeException('Chỉ có thể hủy duyệt đơn hàng đã được duyệt.');
        }

        DB::table('tbl_oder')->where('oder_id', $oderId)->update([
            'oder_status' => 0,
            'updated_at'  => null,
        ]);

        return true;
    }

    /**
     * Map mã trạng thái → tên hiển thị tiếng Việt
     */
    public function getStatusLabel(int $status): string
    {
        $labels = [
            0 => 'Chờ xử lý',
            1 => 'Đã duyệt',
            2 => 'Trong giỏ hàng',
            3 => 'Đã hủy',
        ];

        if (!array_key_exists($status, $labels)) {
            throw new \InvalidArgumentException("Trạng thái không hợp lệ: {$status}");
        }

        return $labels[$status];
    }

    /**
     * Checkout: chuyển các oder từ giỏ hàng (status 2) → chờ xử lý (status 0)
     */
    public function checkout(int $userId, array $orderIds, array $shippingInfo): bool
    {
        if (empty($orderIds)) {
            throw new \InvalidArgumentException('Danh sách đơn hàng không được trống.');
        }

        $required = ['ho_ten', 'so_dien_thoai', 'dia_chi'];
        foreach ($required as $field) {
            if (empty($shippingInfo[$field])) {
                throw new \InvalidArgumentException("Thiếu thông tin giao hàng: {$field}");
            }
        }

        // Xác minh tất cả order thuộc về user này và đang ở giỏ hàng
        $valid = DB::table('tbl_oder')
            ->whereIn('oder_id', $orderIds)
            ->where('oder_id_user', $userId)
            ->where('oder_status', 2)
            ->count();

        if ($valid !== count($orderIds)) {
            throw new \RuntimeException('Một số đơn hàng không hợp lệ hoặc không thuộc về bạn.');
        }

        foreach ($orderIds as $id) {
            DB::table('tbl_oder')->where('oder_id', $id)->update([
                'oder_status'       => 0,
                'ho_ten_nguoi_nhan' => $shippingInfo['ho_ten'],
                'so_dien_thoai'     => $shippingInfo['so_dien_thoai'],
                'dia_chi_giao_hang' => $shippingInfo['dia_chi'],
                'phuong_thuc_tt'    => $shippingInfo['phuong_thuc_tt'] ?? 'cod',
                'updated_at'        => now(),
            ]);
        }

        return true;
    }
}
