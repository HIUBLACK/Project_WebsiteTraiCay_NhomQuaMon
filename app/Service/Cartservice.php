<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Lấy giỏ hàng của user (status = 2)
     */
    public function getCartByUser(int $userId): \Illuminate\Support\Collection
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
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();
    }

    /**
     * Tính tổng tiền giỏ hàng từ collection
     */
    public function calculateTotal(\Illuminate\Support\Collection $cartItems): float
    {
        return $cartItems->sum(function ($item) {
            return $item->product_price * $item->oder_soluong;
        });
    }

    /**
     * Tính tổng số lượng sản phẩm trong giỏ
     */
    public function countTotalItems(\Illuminate\Support\Collection $cartItems): int
    {
        return (int) $cartItems->sum('oder_soluong');
    }

    /**
     * Thêm sản phẩm vào giỏ hoặc tăng số lượng nếu đã có
     */
    public function addToCart(int $userId, int $productId, int $quantity = 1): void
    {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Số lượng phải ít nhất là 1.');
        }

        $existing = DB::table('tbl_oder')
            ->where('oder_id_product', $productId)
            ->where('oder_id_user', $userId)
            ->where('oder_status', 2)
            ->first();

        if ($existing) {
            DB::table('tbl_oder')
                ->where('oder_id', $existing->oder_id)
                ->update(['oder_soluong' => $existing->oder_soluong + $quantity]);
        } else {
            DB::table('tbl_oder')->insert([
                'oder_id_user'    => $userId,
                'oder_id_product' => $productId,
                'oder_soluong'    => $quantity,
                'oder_status'     => 2,
            ]);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function updateQuantity(int $oderId, int $userId, int $quantity): bool
    {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Số lượng phải ít nhất là 1.');
        }

        if ($quantity > 100) {
            throw new \InvalidArgumentException('Số lượng không được vượt quá 100.');
        }

        $affected = DB::table('tbl_oder')
            ->where('oder_id', $oderId)
            ->where('oder_id_user', $userId)
            ->where('oder_status', 2)
            ->update(['oder_soluong' => $quantity]);

        return $affected > 0;
    }

    /**
     * Xóa 1 sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart(int $oderId, int $userId): bool
    {
        $affected = DB::table('tbl_oder')
            ->where('oder_id', $oderId)
            ->where('oder_id_user', $userId)
            ->delete();

        return $affected > 0;
    }

    /**
     * Kiểm tra giỏ hàng có trống khô
     */
    public function isCartEmpty(int $userId): bool
    {
        return !DB::table('tbl_oder')
            ->where('oder_id_user', $userId)
            ->where('oder_status', 2)
            ->exists();
    }
}
