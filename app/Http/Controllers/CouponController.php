<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function add_coupon(){
        $products = DB::table('tbl_product')->get();
        $users = DB::table('users')->get();
        return view('pages_admin.add_coupon', compact('products', 'users'));
    }

    public function all_coupon(){
    $all_coupon = DB::table('tbl_coupon')->orderByDesc('coupon_id')->get();
    return view('pages_admin.all_coupon', compact('all_coupon'));
    }

    public function save_coupon(Request $request){

        // Kiểm tra trùng mã
        $exists = DB::table('tbl_coupon')->where('coupon_code', $request->coupon_code)->exists();
        if ($exists) {
            return back()->with('error', 'Mã giảm giá đã tồn tại!');
        }
        $coupon_id = DB::table('tbl_coupon')->insertGetId([
            'coupon_code' => $request->coupon_code,
            'coupon_type' => $request->coupon_type,
            'coupon_value' => $request->coupon_value,
            'coupon_scope' => $request->coupon_scope,
            'coupon_usage_limit' => $request->coupon_usage_limit ?? 0,
            'coupon_used_count' => 0,
            'coupon_user_usage_mode' => $request->coupon_user_usage_mode ?? 0,
            'coupon_expiry' => $request->coupon_expiry,
            'created_at' => now(),
        ]);

        // Liên kết sản phẩm cụ thể
        if ($request->coupon_scope == 2 && $request->product_ids) {
            foreach ($request->product_ids as $product_id) {
                DB::table('tbl_coupon_product')->insert([
                    'coupon_id' => $coupon_id,
                    'product_id' => $product_id
                ]);
            }
        }
        // Liên kết user cụ thể
        if ($request->customer_scope === 'select' && $request->user_ids) {
            foreach ($request->user_ids as $user_id) {
                DB::table('tbl_coupon_user')->insert([
                    'coupon_id' => $coupon_id,
                    'user_id' => $user_id
                ]);
            }
        }
        // Liên kết rank
        if ($request->rank_scope && is_array($request->rank_scope)) {
            foreach ($request->rank_scope as $rank) {
                if ($rank !== 'all') {
                    DB::table('tbl_coupon_rank')->insert([
                        'coupon_id' => $coupon_id,
                        'rank' => $rank
                    ]);
                }
            }
        }
        // Điều kiện đơn hàng
        DB::table('tbl_coupon_conditions')->insert([
            'coupon_id' => $coupon_id,
            'min_order_value' => $request->min_order_value ?? null,
            'min_order_quantity' => $request->min_order_quantity ?? null
        ]);

        return redirect('/all-coupon')->with('message', 'Thêm thành công');
    }
    public function delete_coupon($id){

    DB::table('tbl_coupon')->where('coupon_id',$id)->delete();

    return redirect('/all-coupon')->with('message','Xóa thành công');
}
}
