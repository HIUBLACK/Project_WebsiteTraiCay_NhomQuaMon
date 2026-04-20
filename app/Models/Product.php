<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Khai báo bảng nếu không đúng chuẩn Laravel (products)
    protected $table = 'tbl_product';

    // Nếu bạn không dùng timestamps (created_at, updated_at)
    public $timestamps = false;

    // Các cột có thể gán dữ liệu hàng loạt
    protected $fillable = [
        'product_name',
        'product_desc',
        'product_content',
        'product_price',
        'stock_quantity',
        'product_image',
        'product_status',
        'category_id',
        'brand_id',
        'deleted_at'
    ];
}
