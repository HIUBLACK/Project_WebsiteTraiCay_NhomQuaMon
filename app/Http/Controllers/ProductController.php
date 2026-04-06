<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Http\Requests;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Redirect;
// use App\Models\Product;


// class ProductController extends Controller
// {
//     public function product(){
//         // $all_category_product = DB::table('tbl_category_product')->get();
//         // $all_product = DB::table('tbl_product')->get();
//         // $manager_category_product = view('pages.product')->with('all_category_product', $all_category_product)->with('all_product', $all_product);
//         // // $manager_product = view('pages.product')->with('all_product', $all_product);
//         // return view("user_layout")->with('pages.product',$manager_category_product);
//          $all_category_product = DB::table('tbl_category_product')->get();

//     // Giới hạn 6 sản phẩm mỗi trang (tùy bạn)
//     $all_product = DB::table('tbl_product')->paginate(6);

//     return view('pages.product', compact('all_category_product', 'all_product'));
//    }
// //    public function user_product(){
// //     $all_category_product = DB::table('tbl_product')->get();
// //     $manager_category_product = view('pages.product')->with('all_product', $all_category_product);
// //     return view("user_layout")->with('pages.product',$manager_category_product);
// // }
//    public function product_detail($product_id){

//          $all_product = DB::table('tbl_product')->where('product_id','=',$product_id)->get();
//          $all_product2 = DB::table('tbl_product')->take(3)->get();
//          $all_product3 = DB::table('tbl_product')->get();
//     $manager_product = view('pages.product_detail')->with('all_product', $all_product)->with('all_product2', $all_product2)->with('all_product3', $all_product3);
//     return view("user_layout")->with('pages.product_detail',$manager_product);

//    }


//    //HIỂN THỊ sản phẩm
//    public function all_product(){
//     $all_product = DB::table('tbl_product')->get();
//     $manager_product = view('pages_admin.all_product')->with('all_product', $all_product);
//     return view("admin_layout")->with('pages_admin.all_product',$manager_product);

// }
// //END HIỂN THỊ DANH MỤC
// public function add_product(){
//         $all_category = DB::table('tbl_category_product')->get();
//         $manager_category = view('pages_admin.add_product')->with('all_oder', $all_category);
//     return view("admin_layout")->with('pages_admin.add_product',$manager_category);;

// }
// //THÊM DANH MỤC
// public function save_product(Request $request){
//     $data = array();
//     $id = $request->input('category_product');
//     $data['product_name'] = $request->product_name;
//     // $data['product_status'] = $request->category_product_status;
//     $data['product_desc'] = $request->product_desc;
//     $data['product_content'] = $request->product_content;
//     $data['product_price'] = $request->product_price;
//     $data['product_status'] = '1';
//     $data['category_id'] = $id;
//     $data['brand_id'] = '1';

//     $get_image = $request->file('product_image');
//     if($get_image){
//         $new_image = rand(0,99).'.'.$get_image->getClientOriginalExtension();
//         $get_image ->move('upload/product',$new_image);
//         $data['product_image'] = $new_image;
//         DB::table("tbl_product")->insert($data);
//         Session::put("message", 'Thêm sản phẩm thành công');
//         return redirect("all-sanpham");
//     }
//     $data['product_image'] = '';
//     DB::table("tbl_product")->insert($data);
//     Session::put("message", 'Thêm sản phẩm thành công');
//     return redirect("all-sanpham");
// }
// //END THÊM DANH MỤC


// // //ẨN HIỆN
// // public function unactivate_category_product($category_product_id){
// //     DB::table("tbl_category_product")->where("category_id",$category_product_id)->update(['category_status'=>1]);
// //     Session::put("message_category_product", 'Hiện danh mục thành công');
// //     return redirect("all-danhmuc-sanpham");

// // }
// // public function activate_category_product($category_product_id){
// //     DB::table("tbl_category_product")->where("category_id",$category_product_id)->update(['category_status'=>0]);
// //     Session::put("message_category_product", 'Ẩn danh mục thành công');
// //     return redirect("all-danhmuc-sanpham");
// // }
// // //END ẨN HIỆN

// // //DELETE DANH MỤC
// // public function delete_category_product($category_product_id){
// //     DB::table("tbl_category_product")->where("category_id",$category_product_id)->delete();
// //     Session::put("message_category_product", 'Xóa danh mục thành công');
// //     return redirect("all-danhmuc-sanpham");
// // }
// // //EDIT DANH MỤC
// // public function edit_category_product($category_product_id){
// //     $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
// //     $manager_category_product = view('pages_admin.edit_category_product')->with('edit_category_product', $edit_category_product);
// //     return view("admin_layout")->with('pages_admin.edit_category_product',$manager_category_product);

// // }
// // //UPDATE DANH MỤC
// // public function update_category_product(Request $request,$category_product_id){
// //     $data1 = array();
// //     $data1['category_name'] = $request->category_product_name;
// //     $data1['category_status'] = $request->category_product_status;
// //     DB::table("tbl_category_product")->where("category_id",$category_product_id)->update($data1);
// //     Session::put("message_category_product", 'Cập nhật danh mục thành công');
// //     return redirect("all-danhmuc-sanpham");
// // }


//  public function san_pham_theo_danh_muc($category_id)
//     {
//         // Lấy sản phẩm theo category_id
//         $products = Product::where('category_id', $category_id)

//         ->get();


//         // Trả về HTML partial (AJAX)
//         return view('pages.product_list', compact('products'));

//     }
//     //xóa sản phẩm
//    public function delete_product($product_id)
// {
//     try {
//         // Lấy thông tin sản phẩm
//         $product = DB::table('tbl_product')->where('product_id', $product_id)->first();

//         // Cố gắng xóa sản phẩm
//         $deleted = DB::table('tbl_product')->where('product_id', $product_id)->delete();

//         if ($deleted) {
//             // Nếu xóa thành công, xóa luôn ảnh
//             if ($product && $product->product_image) {
//                 $image_path = public_path('upload/product/' . $product->product_image);
//                 if (file_exists($image_path)) {
//                     unlink($image_path);
//                 }
//             }

//             Session::put('message_product', 'Xóa sản phẩm thành công');
//         } else {
//             // Nếu không xóa được (ví dụ do ràng buộc FK)
//             Session::put('error_product', 'Không thể xóa sản phẩm vì đang có đơn hàng liên quan.');
//         }

//         return redirect('all-sanpham');

//     } catch (\Exception $e) {
//         // Trường hợp có lỗi hệ thống
//         Session::put('error_product', 'Không thể xóa sản phẩm vì đang có đơn hàng liên quan.');
//         return redirect()->back();
//     }
// }


//     public function edit_product($product_id) {
//     // Lấy sản phẩm cần sửa và join thêm thông tin danh mục
//     $edit_product = DB::table('tbl_product')
//         ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
//         ->where('product_id', $product_id)
//         ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_category_product.category_id as category_id_joined')
//         ->first(); // dùng first thay vì get vì chỉ lấy 1 sản phẩm

//     // Lấy danh sách tất cả danh mục để đổ vào <select>
//     $all_category = DB::table('tbl_category_product')->get();

//     // Gửi dữ liệu sang view
//     $manager_product = view('pages_admin.edit_product')
//         ->with('edit_product', $edit_product)
//         ->with('all_category', $all_category);

//     return view("admin_layout")->with('pages_admin.edit_product', $manager_product);
// }
// public function update_product(Request $request, $product_id)
// {
//     $data = array();
//     $data['product_name'] = $request->product_name;
//     $data['product_price'] = $request->product_price;
//     $data['product_desc'] = $request->product_desc;
//     $data['product_content'] = $request->product_content;
//     $data['product_status'] = $request->product_status;
//     $data['category_id'] = $request->category_product;

//     // Xử lý ảnh nếu người dùng chọn ảnh mới
//     if ($request->hasFile('product_image')) {
//         $image = $request->file('product_image');
//         $image_name = time() . '_' . $image->getClientOriginalName();
//         $image->move('upload/product', $image_name); // Lưu ảnh vào thư mục public/upload/product
//         $data['product_image'] = $image_name;

//         // Xóa ảnh cũ (nếu cần)
//         $old_image = DB::table('tbl_product')->where('product_id', $product_id)->value('product_image');
//         $old_image_path = public_path('upload/product/' . $old_image);
//         if (file_exists($old_image_path)) {
//             unlink($old_image_path);
//         }
//     }

//     DB::table('tbl_product')->where('product_id', $product_id)->update($data);
//     Session::put('message_product', 'Cập nhật sản phẩm thành công');
//     return redirect('all-sanpham');
// }


// }




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class ProductController extends Controller
{
    // READ — Trang sản phẩm người dùng (có phân trang)
    public function product()
    {
        $all_category_product = DB::table('tbl_category_product')->get();
        $all_product = DB::table('tbl_product')->paginate(6);
        return view('pages.product', compact('all_category_product', 'all_product'));
    }

    // READ — Chi tiết sản phẩm
    public function product_detail($product_id)
    {
        $all_product  = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $all_product2 = DB::table('tbl_product')->take(3)->get();
        $all_product3 = DB::table('tbl_product')->get();

        $manager_product = view('pages.product_detail')
            ->with('all_product', $all_product)
            ->with('all_product2', $all_product2)
            ->with('all_product3', $all_product3);

        return view('user_layout')->with('pages.product_detail', $manager_product);
    }

    // READ — Danh sách sản phẩm (admin)
    public function all_product()
    {
        $all_product = DB::table('tbl_product')->get();
        $manager_product = view('pages_admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('pages_admin.all_product', $manager_product);
    }

    // CREATE — Form thêm sản phẩm
    public function add_product()
    {
        $all_category = DB::table('tbl_category_product')->get();
        $manager_category = view('pages_admin.add_product')->with('all_oder', $all_category);
        return view('admin_layout')->with('pages_admin.add_product', $manager_category);
    }


    //CREATE — Lưu sản phẩm mới
    public function save_product(Request $request)
    {
        $request->validate([
            'product_name'     => 'required|string|min:2|max:200|unique:tbl_product,product_name',
            'product_price'    => 'required|numeric|min:1000|max:999999999',
            'product_desc'     => 'required|string|min:10|max:500',
            'product_content'  => 'nullable|string|max:5000',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
        //    'product_name.required'     => 'Tên sản phẩm không được để trống.',
        //     'product_name.min'          => 'Tên sản phẩm phải có ít nhất 2 ký tự.',
        //     'product_name.max'          => 'Tên sản phẩm không được quá 200 ký tự.',
        //     'product_name.unique'       => 'Tên sản phẩm này đã tồn tại.',
        //     'product_price.required'    => 'Giá sản phẩm không được để trống.',
        //     'product_price.numeric'     => 'Giá sản phẩm phải là số.',
        //     'product_price.min'         => 'Giá sản phẩm phải ít nhất 1,000đ.',
        //     'product_desc.required'     => 'Mô tả ngắn không được để trống.',
        //     'product_desc.min'          => 'Mô tả phải có ít nhất 10 ký tự.',
        //     'category_product.required' => 'Vui lòng chọn danh mục.',
        //     'category_product.exists'   => 'Danh mục không hợp lệ.',
        //     'product_image.image'       => 'File phải là hình ảnh.',
        //     'product_image.mimes'       => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
        //     'product_image.max'         => 'Ảnh không được quá 2MB.',
        ]);

        $data = [
            'product_name'    => $request->product_name,
            'product_desc'    => $request->product_desc,
            'product_content' => $request->product_content,
            'product_price'   => $request->product_price,
            'product_status'  => 1,
            'category_id'     => $request->category_product,
            'brand_id'        => 1,
            'product_image'   => '',
            'created_at'      => now(),   // thêm dòng này
            'updated_at'      => now(),   // thêm dòng này
        ];

        if ($request->hasFile('product_image')) {
            $get_image  = $request->file('product_image');
            $new_image  = time() . '_' . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('upload/product', $new_image);
            $data['product_image'] = $new_image;
        }

        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm sản phẩm thành công');
        return redirect('all-sanpham');
    }

    // UPDATE — Form sửa sản phẩm
    public function edit_product($product_id)
    {
        $edit_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('product_id', $product_id)
            ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_category_product.category_id as category_id_joined')
            ->first();

        $all_category = DB::table('tbl_category_product')->get();

        $manager_product = view('pages_admin.edit_product')
            ->with('edit_product', $edit_product)
            ->with('all_category', $all_category);

        return view('admin_layout')->with('pages_admin.edit_product', $manager_product);
    }

    // UPDATE — Lưu chỉnh sửa sản phẩm
    public function update_product(Request $request, $product_id)
    {
        $request->validate([
            'product_name'     => 'required|string|min:2|max:200|unique:tbl_product,product_name,' . $product_id . ',product_id',
            'product_price'    => 'required|numeric|min:1000|max:999999999',
            'product_desc'     => 'required|string|min:10|max:500',
            'product_content'  => 'nullable|string|max:5000',
            'product_status'   => 'required|in:0,1',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'product_name.required'     => 'Tên sản phẩm không được để trống.',
            'product_name.min'          => 'Tên sản phẩm phải có ít nhất 2 ký tự.',
            'product_name.unique'       => 'Tên sản phẩm này đã tồn tại.',
            'product_price.required'    => 'Giá sản phẩm không được để trống.',
            'product_price.numeric'     => 'Giá sản phẩm phải là số.',
            'product_price.min'         => 'Giá sản phẩm phải ít nhất 1,000đ.',
            'product_desc.required'     => 'Mô tả ngắn không được để trống.',
            'product_desc.min'          => 'Mô tả phải có ít nhất 10 ký tự.',
            'product_status.required'   => 'Vui lòng chọn trạng thái.',
            'product_status.in'         => 'Trạng thái không hợp lệ.',
            'category_product.required' => 'Vui lòng chọn danh mục.',
            'product_image.image'       => 'File phải là hình ảnh.',
            'product_image.mimes'       => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'product_image.max'         => 'Ảnh không được quá 2MB.',
        ]);

        $data = [
            'product_name'    => $request->product_name,
            'product_price'   => $request->product_price,
            'product_desc'    => $request->product_desc,
            'product_content' => $request->product_content,
            'product_status'  => $request->product_status,
            'category_id'     => $request->category_product,
        ];

        if ($request->hasFile('product_image')) {
            $image      = $request->file('product_image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move('upload/product', $image_name);
            $data['product_image'] = $image_name;

            $old_image      = DB::table('tbl_product')->where('product_id', $product_id)->value('product_image');
            $old_image_path = public_path('upload/product/' . $old_image);
            if ($old_image && file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message_product', 'Cập nhật sản phẩm thành công');
        return redirect('all-sanpham');
    }

    // DELETE — Xóa sản phẩm
    public function delete_product($product_id)
    {
        try {
            $product = DB::table('tbl_product')->where('product_id', $product_id)->first();
            $deleted = DB::table('tbl_product')->where('product_id', $product_id)->delete();

            if ($deleted) {
                if ($product && $product->product_image) {
                    $image_path = public_path('upload/product/' . $product->product_image);
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                Session::put('message_product', 'Xóa sản phẩm thành công');
            } else {
                Session::put('error_product', 'Không thể xóa sản phẩm vì đang có đơn hàng liên quan.');
            }

            return redirect('all-sanpham');

        } catch (\Exception $e) {
            Session::put('error_product', 'Không thể xóa sản phẩm vì đang có đơn hàng liên quan.');
            return redirect()->back();
        }
    }

    // Lọc sản phẩm theo danh mục (AJAX)
    public function san_pham_theo_danh_muc($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        return view('pages.product_list', compact('products'));
    }
}

