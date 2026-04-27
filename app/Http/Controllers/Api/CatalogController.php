<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = DB::table('tbl_category_product')
            ->orderBy('category_name')
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function products(): JsonResponse
    {
        $products = DB::table('tbl_product')
            ->leftJoin('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->whereNull('tbl_product.deleted_at')
            ->select(
                'tbl_product.product_id',
                'tbl_product.product_name',
                'tbl_product.product_price',
                'tbl_product.product_desc',
                'tbl_product.product_content',
                'tbl_product.product_image',
                'tbl_product.product_status',
                'tbl_product.stock_quantity',
                'tbl_product.category_id',
                'tbl_category_product.category_name'
            )
            ->orderByDesc('tbl_product.product_id')
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function showProduct(int $productId): JsonResponse
    {
        $product = DB::table('tbl_product')
            ->leftJoin('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('tbl_product.product_id', $productId)
            ->whereNull('tbl_product.deleted_at')
            ->select(
                'tbl_product.product_id',
                'tbl_product.product_name',
                'tbl_product.product_price',
                'tbl_product.product_desc',
                'tbl_product.product_content',
                'tbl_product.product_image',
                'tbl_product.product_status',
                'tbl_product.stock_quantity',
                'tbl_product.category_id',
                'tbl_category_product.category_name'
            )
            ->first();

        if (!$product) {
            return response()->json([
                'message' => 'Không tìm thấy sản phẩm.',
            ], 404);
        }

        return response()->json([
            'data' => $product,
        ]);
    }
}
