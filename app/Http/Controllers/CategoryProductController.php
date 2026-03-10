<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CategoryProductController extends Controller
{
    //HIỂN THỊ DANH MỤC
    public function all_category_product(){
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('pages_admin.all_category_product')->with('all_category_product', $all_category_product);
        return view("admin_layout")->with('pages_admin.all_category_product',$manager_category_product);

    }
    //END HIỂN THỊ DANH MỤC
    public function add_category_product(){
        return view("pages_admin.add_category_product");

    }
    //THÊM DANH MỤC
    public function save_category_product(Request $request){
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_status'] = $request->category_product_status;

        DB::table("tbl_category_product")->insert($data);
        Session::put("message_category_product", 'Thêm danh mục thành công');
        return redirect("all-danhmuc-sanpham");
    }
    //END THÊM DANH MỤC


    //ẨN HIỆN
    public function unactivate_category_product($category_product_id){
        DB::table("tbl_category_product")->where("category_id",$category_product_id)->update(['category_status'=>1]);
        Session::put("message_category_product", 'Hiện danh mục thành công');
        return redirect("all-danhmuc-sanpham");

    }
    public function activate_category_product($category_product_id){
        DB::table("tbl_category_product")->where("category_id",$category_product_id)->update(['category_status'=>0]);
        Session::put("message_category_product", 'Ẩn danh mục thành công');
        return redirect("all-danhmuc-sanpham");
    }
    //END ẨN HIỆN

    //DELETE DANH MỤC
    public function delete_category_product($category_product_id){
        DB::table("tbl_category_product")->where("category_id",$category_product_id)->delete();
        Session::put("message_category_product", 'Xóa danh mục thành công');
        return redirect("all-danhmuc-sanpham");
    }
    //EDIT DANH MỤC
    public function edit_category_product($category_product_id){
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('pages_admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view("admin_layout")->with('pages_admin.edit_category_product',$manager_category_product);

    }
    //UPDATE DANH MỤC
    public function update_category_product(Request $request,$category_product_id){
        $data1 = array();
        $data1['category_name'] = $request->category_product_name;
        $data1['category_status'] = $request->category_product_status;
        DB::table("tbl_category_product")->where("category_id",$category_product_id)->update($data1);
        Session::put("message_category_product", 'Cập nhật danh mục thành công');
        return redirect("all-danhmuc-sanpham");
    }
}
