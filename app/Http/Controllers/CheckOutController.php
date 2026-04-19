<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;
use Carbon\Carbon;
class CheckOutController extends Controller
{
    public function thanh_toan(){

    if (!Auth::check()) {
        return redirect('/dang-nhap-dang-ky');
    }

    $id = Auth::id();

    $all_oder = DB::table('tbl_oder')
    ->join('tbl_product','tbl_oder.oder_id_product','=','tbl_product.product_id')
    ->where('tbl_oder.oder_status', 2)
    ->where('tbl_oder.oder_id_user', $id)
    ->select(
        'tbl_oder.*',
        'tbl_product.product_name',
        'tbl_product.product_price',
        'tbl_product.product_image',
        DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
    )
    ->get();

    if ($all_oder->isEmpty()) {
        return redirect('/gio-hang')->with('error', 'Giỏ hàng trống');
    }

    $total = $all_oder->sum(function($item){
        return $item->product_price * $item->oder_soluong;
    });

    // 🔥 COUPON
    $discount = 0;

    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');

        foreach ($all_oder as $item) {

            $apply = true;

            if ($coupon->coupon_scope == 2) {
                $check = DB::table('tbl_coupon_product')
                    ->where('coupon_id', $coupon->coupon_id)
                    ->where('product_id', $item->oder_id_product)
                    ->first();

                if (!$check) $apply = false;
            }

            if ($apply) {
                if ($coupon->coupon_type == 1) {
                    $discount += ($item->product_price * $item->oder_soluong * $coupon->coupon_value)/100;
                } else {
                    $discount = $coupon->coupon_value;
                }
            }
        }
    }

    $total_after = max(0, $total - $discount);

    return view('pages.checkout', compact(
        'all_oder','total','discount','total_after'
    ));
}
   public function xu_ly_thanh_toan(Request $request){

    // ✅ validate
    $request->validate([
        'name' => 'required|min:3',
        'address' => 'required|min:5',
        'phone' => 'required'
    ]);

    $user_id = Auth::id();

    $cart = DB::table('tbl_oder')
        ->where('oder_id_user',$user_id)
        ->where('oder_status',2)
        ->get();

    if ($cart->isEmpty()) {
        return redirect('/gio-hang')->with('error','Giỏ hàng trống');
    }

    // ✅ tính tổng
    $total = 0;
    foreach ($cart as $item){
        $price = DB::table('tbl_product')
            ->where('product_id',$item->oder_id_product)
            ->value('product_price');

        $total += $price * $item->oder_soluong;
    }

    // ✅ COUPON
    $discount = 0;

    if (Session::has('coupon')) {

        $coupon = Session::get('coupon');

        foreach ($cart as $item) {

            $price = DB::table('tbl_product')
                ->where('product_id',$item->oder_id_product)
                ->value('product_price');

            $apply = true;

            if ($coupon->coupon_scope == 2) {
                $check = DB::table('tbl_coupon_product')
                    ->where('coupon_id',$coupon->coupon_id)
                    ->where('product_id',$item->oder_id_product)
                    ->first();

                if (!$check) $apply = false;
            }

            if ($apply) {
                if ($coupon->coupon_type == 1) {
                    $discount += ($price * $item->oder_soluong * $coupon->coupon_value)/100;
                } else {
                    $discount = $coupon->coupon_value;
                }
            }
        }
    }

    $total_after = max(0, $total - $discount);

    // ✅ LƯU ĐƠN CHÍNH
    $order_main_id = DB::table('tbl_order_main')->insertGetId([
        'user_id' => $user_id,
        'name' => $request->name,
        'address' => $request->address,
        'phone' => $request->phone,
        'total' => $total_after,
        'payment_method' => $request->payment_method,
        'created_at'      => now(),

    ]);

    // ✅ GẮN ORDER_ID + UPDATE STATUS
    foreach ($cart as $item){
        DB::table('tbl_oder')
            ->where('oder_id',$item->oder_id)
            ->update([
                'oder_status'=>1,
                'order_id'=>$order_main_id
            ]);
    }

    // ✅ CẬP NHẬT TỔNG TIỀN & XẾP HẠNG
    // Cộng dồn tổng tiền đã mua
    DB::table('users')->where('id', $user_id)->increment('total_spent', $total_after);

    // Lấy tổng tiền mới
    $tong_tien = DB::table('users')->where('id', $user_id)->value('total_spent');
    // Xác định xếp hạng
    $rank = 'Thường';
    if ($tong_tien >= 10000000) {
        $rank = 'Kim cương';
    } elseif ($tong_tien >= 5000000) {
        $rank = 'Vàng';
    } elseif ($tong_tien >= 1000000) {
        $rank = 'Bạc';
    }
    DB::table('users')->where('id', $user_id)->update(['rank' => $rank]);

    // ✅ UPDATE COUPON
    if (Session::has('coupon')) {

        $coupon = Session::get('coupon');

        DB::table('tbl_coupon')
            ->where('coupon_id',$coupon->coupon_id)
            ->increment('coupon_used_count');

        DB::table('tbl_coupon_usage')->insert([
            'coupon_id'=>$coupon->coupon_id,
            'user_id'=>$user_id
        ]);

        Session::forget('coupon');
    }

    return redirect('/')->with('message','Đặt hàng thành công');
}
    //giảm giá


    public function apply_coupon(Request $request)
    {
        $coupon = DB::table('tbl_coupon')
            ->where('coupon_code', $request->coupon_code)
            ->where('coupon_condition', 1)
            ->first();

        if (!$coupon) return back()->with('error','Sai mã');

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry))
            return back()->with('error','Hết hạn');

        if ($coupon->coupon_usage_limit > 0 &&
            $coupon->coupon_used_count >= $coupon->coupon_usage_limit)
            return back()->with('error','Hết lượt');

        $user_id = Session::get('user_id');

        $used = DB::table('tbl_coupon_usage')
            ->where('coupon_id',$coupon->coupon_id)
            ->where('user_id',$user_id)
            ->first();

        if ($used) return back()->with('error','Đã dùng');

        Session::put('coupon',$coupon);

        return back()->with('message','OK');
    }

    public function remove_coupon(){
        Session::forget('coupon');
        return back();
    }


}
