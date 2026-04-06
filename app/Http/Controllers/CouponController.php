<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function add_coupon(){
        $products = DB::table('tbl_product')->get();
        return view('pages_admin.add_coupon', compact('products'));
    }

    public function all_coupon(){
    $all_coupon = DB::table('tbl_coupon')->orderByDesc('coupon_id')->get();
    return view('pages_admin.all_coupon', compact('all_coupon'));
    }

    public function save_coupon(Request $request){

        $coupon_id = DB::table('tbl_coupon')->insertGetId([
            'coupon_code' => $request->coupon_code,
            'coupon_type' => $request->coupon_type,
            'coupon_value' => $request->coupon_value,
            'coupon_scope' => $request->coupon_scope,
            'coupon_usage_limit' => $request->coupon_usage_limit ?? 0,
            'coupon_used_count' => 0,
            'coupon_expiry' => $request->coupon_expiry,
            'created_at' => now(),
        ]);

        if ($request->coupon_scope == 2 && $request->product_ids) {
            foreach ($request->product_ids as $product_id) {
                DB::table('tbl_coupon_product')->insert([
                    'coupon_id' => $coupon_id,
                    'product_id' => $product_id
                ]);
            }
        }

        return redirect('/all-coupon')->with('message', 'Thêm thành công');
    }
    public function delete_coupon($id){

    DB::table('tbl_coupon')->where('coupon_id',$id)->delete();

    return redirect('/all-coupon')->with('message','Xóa thành công');
}
}
