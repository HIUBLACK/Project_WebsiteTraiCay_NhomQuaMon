<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryProductController extends Controller
{
    public function all_category_product()
    {
        $all_category_product = DB::table('tbl_category_product')
            ->leftJoin('tbl_product', function ($join) {
                $join->on('tbl_category_product.category_id', '=', 'tbl_product.category_id')
                    ->whereNull('tbl_product.deleted_at');
            })
            ->select(
                'tbl_category_product.*',
                DB::raw('COUNT(tbl_product.product_id) as active_product_count')
            )
            ->groupBy(
                'tbl_category_product.category_id',
                'tbl_category_product.category_name',
                'tbl_category_product.category_status',
                'tbl_category_product.created_at',
                'tbl_category_product.updated_at'
            )
            ->get();

        $manager_category_product = view('pages_admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('pages_admin.all_category_product', $manager_category_product);
    }

    public function add_category_product()
    {
        return view('pages_admin.add_category_product');
    }

    public function save_category_product(Request $request)
    {
        DB::table('tbl_category_product')->insert([
            'category_name' => $request->category_product_name,
            'category_status' => $request->category_product_status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::put('message_category_product', 'Thêm danh mục thành công');
        return redirect('all-danhmuc-sanpham');
    }

    public function unactivate_category_product($category_product_id)
    {
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update([
            'category_status' => 1,
            'updated_at' => now(),
        ]);
        Session::put('message_category_product', 'Hiện danh mục thành công');
        return redirect('all-danhmuc-sanpham');
    }

    public function activate_category_product($category_product_id)
    {
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update([
            'category_status' => 0,
            'updated_at' => now(),
        ]);
        Session::put('message_category_product', 'Ẩn danh mục thành công');
        return redirect('all-danhmuc-sanpham');
    }

    public function delete_category_product($category_product_id)
    {
        $activeProducts = DB::table('tbl_product')
            ->where('category_id', $category_product_id)
            ->whereNull('deleted_at')
            ->count();

        if ($activeProducts > 0) {
            Session::put('message_category_product', 'Không thể xóa danh mục vì vẫn còn sản phẩm trong danh mục.');
            return redirect('all-danhmuc-sanpham');
        }

        $usedInOrders = DB::table('tbl_product')
            ->join('tbl_oder', 'tbl_product.product_id', '=', 'tbl_oder.oder_id_product')
            ->where('tbl_product.category_id', $category_product_id)
            ->exists();

        if ($usedInOrders) {
            Session::put('message_category_product', 'Không thể xóa danh mục vì danh mục đã được sử dụng trong đơn hàng.');
            return redirect('all-danhmuc-sanpham');
        }

        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        Session::put('message_category_product', 'Xóa danh mục thành công');
        return redirect('all-danhmuc-sanpham');
    }

    public function edit_category_product($category_product_id)
    {
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('pages_admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('pages_admin.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request, $category_product_id)
    {
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update([
            'category_name' => $request->category_product_name,
            'category_status' => $request->category_product_status,
            'updated_at' => now(),
        ]);

        Session::put('message_category_product', 'Cập nhật danh mục thành công');
        return redirect('all-danhmuc-sanpham');
    }
}
