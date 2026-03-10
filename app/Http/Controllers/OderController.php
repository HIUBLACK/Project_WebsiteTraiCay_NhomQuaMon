<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class OderController extends Controller
{
    public function all_oder() {
        $all_oder = DB::table('tbl_oder')->where('oder_status','!=','2')->orderByDesc('oder_id')->get();
        $manager_oder = view('pages_admin.all_oder')->with('all_oder', $all_oder);
        return view("admin_layout")->with('pages_admin.all_oder',$manager_oder);
    }

    public function detail_oder() {
         if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
        }
        // $all_oder = DB::table('tbl_oder')->where('oder_status','!=','2')->orderByDesc('oder_id')->get();
        // $manager_oder = view('pages.oder_history')->with('all_oder', $all_oder);
        // //session()->put('thongbao', $dem-2);
        // return view("user_layout")->with('oder_history',$manager_oder);

        $id = Auth::id();
        $all_oder = DB::table('tbl_oder')
        ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
        ->where('tbl_oder.oder_status', '!=','2')
        ->where('tbl_oder.oder_id_user', $id)
        ->orderByDesc('tbl_oder.oder_id')
        ->select(
            'tbl_oder.*',
            'tbl_product.product_image',
            'tbl_product.product_name',
            'tbl_product.product_price',
            DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
        )
        ->get();

    // Tính tổng tiền tất cả đơn hàng

    $total = $all_oder->sum('thanh_tien');
    $sum_sp =$all_oder->sum('oder_soluong');

    // Truyền ra view
    $manager_oder = view('pages.oder_history')
        ->with('all_oder', $all_oder)
        ->with('total', $total)
        ->with('sum_sp', $sum_sp);

    return view("user_layout")->with('pages.oder_history', $manager_oder);
    }
    public function unactivate_category_product($category_product_id){
        DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['oder_status'=>1]);
        DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['updated_at'=>now()]);
        Session::put("message_category_product", 'Duyệt đơn thành công');
        return redirect("all-oder");
    }
    public function activate_category_product($category_product_id){
        DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['oder_status'=>0]);
        DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['updated_at'=>null]);
        Session::put("message_category_product", 'Hủy duyệt đơn thành công');
        return redirect("all-oder");
    }
    public function delete_oder($oder_id) {
         DB::table("tbl_oder")->where("oder_id",$oder_id)->delete();

        return redirect("lich-su-dat-hang")->with('message', 'Hủy đơn hàng thành công!');
    }

}
