<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function product()
    {
        $all_category_product = DB::table('tbl_category_product')->where('category_status', 1)->get();
        $all_product = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->paginate(6);

        return view('pages.product', compact('all_category_product', 'all_product'));
    }

    public function product_detail($product_id)
    {
        $all_product = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->get();

        $all_product2 = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->take(3)
            ->get();

        $all_product3 = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->get();

        $manager_product = view('pages.product_detail')
            ->with('all_product', $all_product)
            ->with('all_product2', $all_product2)
            ->with('all_product3', $all_product3);

        return view('user_layout')->with('pages.product_detail', $manager_product);
    }

    public function all_product()
    {
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->whereNull('tbl_product.deleted_at')
            ->select('tbl_product.*', 'tbl_category_product.category_name')
            ->orderByDesc('tbl_product.product_id')
            ->get();

        return view('pages_admin.all_product', compact('all_product'));
    }

    public function add_product()
    {
        $all_category = DB::table('tbl_category_product')->get();
        $manager_category = view('pages_admin.add_product')->with('all_oder', $all_category);

        return view('admin_layout')->with('pages_admin.add_product', $manager_category);
    }

    public function save_product(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|min:2|max:200|unique:tbl_product,product_name',
            'product_price' => 'required|numeric|min:1000|max:999999999',
            'stock_quantity' => 'required|integer|min:0|max:1000000',
            'product_desc' => 'required|string|min:10|max:500',
            'product_content' => 'nullable|string|max:5000',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_price' => $request->product_price,
            'stock_quantity' => $request->stock_quantity,
            'product_status' => 1,
            'category_id' => $request->category_product,
            'brand_id' => 1,
            'product_image' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($request->hasFile('product_image')) {
            $get_image = $request->file('product_image');
            $new_image = time() . '_' . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('upload/product', $new_image);
            $data['product_image'] = $new_image;
        }

        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm sản phẩm thành công');

        return redirect('all-sanpham');
    }

    public function edit_product($product_id)
    {
        $edit_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('product_id', $product_id)
            ->whereNull('tbl_product.deleted_at')
            ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_category_product.category_id as category_id_joined')
            ->first();

        $all_category = DB::table('tbl_category_product')->get();

        $manager_product = view('pages_admin.edit_product')
            ->with('edit_product', $edit_product)
            ->with('all_category', $all_category);

        return view('admin_layout')->with('pages_admin.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id)
    {
        $request->validate([
            'product_name' => 'required|string|min:2|max:200|unique:tbl_product,product_name,' . $product_id . ',product_id',
            'product_price' => 'required|numeric|min:1000|max:999999999',
            'stock_quantity' => 'required|integer|min:0|max:1000000',
            'product_desc' => 'required|string|min:10|max:500',
            'product_content' => 'nullable|string|max:5000',
            'product_status' => 'required|in:0,1',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'stock_quantity' => $request->stock_quantity,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_status' => $request->product_status,
            'category_id' => $request->category_product,
            'updated_at' => now(),
        ];

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move('upload/product', $image_name);
            $data['product_image'] = $image_name;

            $old_image = DB::table('tbl_product')->where('product_id', $product_id)->value('product_image');
            $old_image_path = public_path('upload/product/' . $old_image);
            if ($old_image && file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message_product', 'Cập nhật sản phẩm thành công');

        return redirect('all-sanpham');
    }

    public function delete_product($product_id)
    {
        $product = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            Session::put('error_product', 'Không tìm thấy sản phẩm hoặc sản phẩm đã bị xóa mềm.');
            return redirect('all-sanpham');
        }

        DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->update([
                'deleted_at' => now(),
                'product_status' => 0,
                'updated_at' => now(),
            ]);

        Session::put('message_product', 'Đã xóa mềm sản phẩm thành công');
        return redirect('all-sanpham');
    }

    public function san_pham_theo_danh_muc($category_id)
    {
        $products = Product::where('category_id', $category_id)
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->get();

        return view('pages.product_list', compact('products'));
    }
}
