<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Lấy tất cả sản phẩm (có phân trang)
     */
    public function getAllProducts(int $perPage = 6)
    {
        return DB::table('tbl_product')->paginate($perPage);
    }

    /**
     * Lấy sản phẩm theo ID
     */
    public function getProductById(int $productId)
    {
        return DB::table('tbl_product')
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Lấy sản phẩm theo danh mục
     */
    public function getProductsByCategory(int $categoryId): \Illuminate\Support\Collection
    {
        return DB::table('tbl_product')
            ->where('category_id', $categoryId)
            ->where('product_status', 1)
            ->get();
    }

    /**
     * Tính giá sau khi áp dụng % giảm giá
     * Trả về float, không âm, không vượt quá giá gốc
     */
    public function calculateDiscountedPrice(float $originalPrice, float $discountPercent): float
    {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Phần trăm giảm giá phải từ 0 đến 100.');
        }

        if ($originalPrice < 0) {
            throw new \InvalidArgumentException('Giá sản phẩm không được âm.');
        }

        $discounted = $originalPrice * (1 - $discountPercent / 100);
        return round($discounted, 0);
    }

    /**
     * Kiểm tra sản phẩm còn hàng không
     */
    public function isInStock(int $productId): bool
    {
        $product = DB::table('tbl_product')
            ->where('product_id', $productId)
            ->first();

        if (!$product) {
            return false;
        }

        return isset($product->product_stock) ? $product->product_stock > 0 : true;
    }

    /**
     * Tạo sản phẩm mới — trả về product_id vừa tạo
     */
    public function createProduct(array $data): int
    {
        $required = ['product_name', 'product_price', 'category_id'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("Thiếu trường bắt buộc: {$field}");
            }
        }

        if ($data['product_price'] < 0) {
            throw new \InvalidArgumentException('Giá sản phẩm không được âm.');
        }

        return DB::table('tbl_product')->insertGetId([
            'product_name'    => $data['product_name'],
            'product_price'   => $data['product_price'],
            'product_desc'    => $data['product_desc']    ?? '',
            'product_content' => $data['product_content'] ?? '',
            'product_image'   => $data['product_image']   ?? '',
            'product_status'  => $data['product_status']  ?? 1,
            'category_id'     => $data['category_id'],
            'brand_id'        => $data['brand_id']        ?? 1,
        ]);
    }

    /**
     * Cập nhật sản phẩm — trả về số dòng bị ảnh hưởng
     */
    public function updateProduct(int $productId, array $data): int
    {
        if (isset($data['product_price']) && $data['product_price'] < 0) {
            throw new \InvalidArgumentException('Giá sản phẩm không được âm.');
        }

        return DB::table('tbl_product')
            ->where('product_id', $productId)
            ->update($data);
    }

    /**
     * Xóa sản phẩm — kiểm tra trước khi xóa
     */
    public function deleteProduct(int $productId): bool
    {
        $hasOrder = DB::table('tbl_oder')
            ->where('oder_id_product', $productId)
            ->exists();

        if ($hasOrder) {
            throw new \RuntimeException('Không thể xóa sản phẩm đang có trong đơn hàng.');
        }

        $product = DB::table('tbl_product')->where('product_id', $productId)->first();
        if (!$product) {
            throw new \RuntimeException('Sản phẩm không tồn tại.');
        }

        DB::table('tbl_product')->where('product_id', $productId)->delete();
        return true;
    }

    /**
     * Format giá tiền sang định dạng Việt Nam: 150000 → "150.000 đ"
     */
    public function formatPrice(float $price): string
    {
        if ($price < 0) {
            throw new \InvalidArgumentException('Giá không được âm.');
        }
        return number_format($price, 0, ',', '.') . ' đ';
    }
}
