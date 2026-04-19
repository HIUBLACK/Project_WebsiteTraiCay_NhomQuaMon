<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function admin_login(){
        return view("pages_admin.admin_login");
    }
    public function admin_dashboard(){
        return view("pages_admin.admin_dashboard");
    }
    public function admin_register(){
        return view("pages_admin.admin_register");
    }



    //admin check
    public function admin_check(Request $request){
        $admin_username = $request->admin_username;
        $admin_password = $request->admin_password;

        $result = DB::table('tbl_admin') ->where('admin_username', $admin_username) -> where('admin_password', $admin_password) -> first();
        if ($result) {
            // Đăng nhập thành công
            session::put('admin_name', $v = $result->admin_name);
            session::put('admin_id', $v = $result->admin_id);
            return Redirect::to('/admin-trang-chu');
        } else {
            // Đăng nhập thất bại
            session::put('massge', 'Tên đăng nhập hoặc mật khẩu sai');
            return Redirect::to('/admin-dang-nhap');
        }
    }
    public function admin_logout(){
        session::put('admin_name',null);
        session::put('admin_id',null);
        return Redirect::to('/admin-dang-nhap');
    }
    //Xếp hạng người dùng
 public function xep_hang_nguoi_dung(){
    $all_rank_user = DB::table('users')
        ->leftJoin('tbl_oder', 'users.id', '=', 'tbl_oder.oder_id_user')
        ->leftJoin('tbl_order_main', 'tbl_oder.oder_id', '=', 'tbl_order_main.order_id')
        ->select(
            'users.id',
            'users.name',
            'users.email',
            'users.rank',

            DB::raw('COALESCE(SUM(tbl_oder.oder_soluong), 0) as total_quantity'),

            // ✅ FIX CHUẨN
            DB::raw('COALESCE(SUM(DISTINCT tbl_order_main.total), 0) as total_amount')
        )
        ->groupBy(
            'users.id',
            'users.name',
            'users.email',
            'users.rank'
        )
        ->orderBy('total_amount', 'desc')
        ->orderBy('total_quantity', 'desc')
        ->get();

    return view('pages_admin.all_rank_user')
        ->with('all_rank_user', $all_rank_user);
}
}
