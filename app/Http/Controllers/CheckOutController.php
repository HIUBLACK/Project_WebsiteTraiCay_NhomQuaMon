<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;
class CheckOutController extends Controller
{
    public function thanh_toan(){
         if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
        }
        $id = Auth::id();
        $all_oder = DB::table('tbl_oder')
        ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
        ->where('tbl_oder.oder_status', 2)
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
            if($all_oder->count()!=0){
                 $total = $all_oder->sum('thanh_tien');
                $sum_sp =$all_oder->sum('oder_soluong');


    // Truyền ra view
    $manager_oder = view('pages.checkout')
        ->with('all_oder', $all_oder)
        ->with('total', $total)
        ->with('sum_sp', $sum_sp);


    return view("user_layout")->with('pages.checkout', $manager_oder);
            }else{
                return redirect("san-pham")->with('message', '!Giỏ hàng trống, vui lòng thêm sản phẩm vào giỏ');
            }
    // Tính tổng tiền tất cả đơn hàng


    }
    public function xu_ly_thanh_toan(Request $request){
    //     $id = Auth::id(); // lấy id người dùng đang đăng nhập

    // $all_oder = DB::table('tbl_oder')->get();
    //     ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
    //     ->where('tbl_oder.oder_id_user', '=', $id)
    //     ->where('tbl_oder.oder_status', '=', 2)
    //     ->select('tbl_oder.*', 'tbl_product.product_name', 'tbl_product.product_image', 'tbl_product.product_price',
    //              DB::raw('tbl_product.product_price * tbl_oder.oder_soluong as thanh_tien'))


    // $total = $all_oder->sum('thanh_tien');

        //  $manager_oder = view('pages.oder_history')
        // ->with('all_oder', $all_oder);
        // ->with('total', $total);




        $orderIds = $request->input('oder_ids');

     // Đây là mảng các order_id

    foreach ($orderIds as $id) {
        // xử lý từng đơn hàng, ví dụ cập nhật trạng thái
        DB::table('tbl_oder')
            ->where('oder_id', $id)
            ->update(['oder_status' => 0]); // ví dụ: trạng thái = đã thanh toán
    }


    //  return view("user_layout")->with('pages.oder_history', $manager_oder);
     return redirect("lich-su-dat-hang")->with('message', 'Đặt hàng thành công!');

    }


}
