<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class HomeController extends Controller
{
    public function user(){
         $all_category_product = DB::table('tbl_category_product')->get();
        $all_product = DB::table('tbl_product')->get();
        $manager_category_product = view('pages.home')->with('all_category_product', $all_category_product)->with('all_product', $all_product);
        // $manager_product = view('pages.product')->with('all_product', $all_product);
        return view("user_layout")->with('pages.home',$manager_category_product);

        // return view('pages.home');
    }
    public function cart(Request $request,$product_id){
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
        }
        $result = DB::table("tbl_oder")->where("oder_id_product",$product_id)->where('oder_status','=','2')->first();
        $data = array();
        if($result){
            $sl =  $result->oder_soluong + 1;

            $data['oder_soluong'] = $sl;
             DB::table("tbl_oder")->where('oder_id','=',$result->oder_id)->update($data);

        }else{

            $data['oder_soluong'] = '1';

            $data['oder_status'] = '2';
            $data['oder_id_user'] = Auth::id();
            $data['oder_id_product'] = $product_id;
            DB::table("tbl_oder")->insert($data);

        }



        return redirect("/gio-hang");

    }
    //THEM GIỎ HÀNG
    public function gio_hang(){
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

    // Tính tổng tiền tất cả đơn hàng

    $total = $all_oder->sum('thanh_tien');
    $sum_sp =$all_oder->sum('oder_soluong');

    // Truyền ra view
    $manager_oder = view('pages.cart')
        ->with('all_oder', $all_oder)
        ->with('total', $total)
        ->with('sum_sp', $sum_sp);

    return view("user_layout")->with('pages.cart', $manager_oder);


    }
    //Update giỏ hàng
    public function update_gio_hang(Request $request,$oder_id){
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
        }
        $data = array();
        $action = $request->input('action');
        $TongSL = $request->input('soluong');
        if($action =='giam'){
            $data['oder_soluong'] = $TongSL ;
        }else{
            $data['oder_soluong'] = $TongSL ;
        }

        DB::table("tbl_oder")->where("oder_id",$oder_id)->update($data);
        return redirect("/gio-hang");
    }
    //Xóa giỏ hàng
     public function delete_gio_hang(Request $request,$oder_id){
       DB::table("tbl_oder")->where("oder_id",$oder_id)->delete();
        return redirect("/gio-hang");


    }

    // public function checkout(){
    //      if (!Auth::check()) {
    //         return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
    //     }
    //     $id = Auth::id();
    //     $all_oder = DB::table('tbl_oder')
    //     ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
    //     ->where('tbl_oder.oder_status', 2)
    //     ->where('tbl_oder.oder_id_user', $id)
    //     ->orderByDesc('tbl_oder.oder_id')
    //     ->select(
    //         'tbl_oder.*',
    //         'tbl_product.product_image',
    //         'tbl_product.product_name',
    //         'tbl_product.product_price',
    //         DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
    //     )
    //     ->get();

    // // Tính tổng tiền tất cả đơn hàng

    // $total = $all_oder->sum('thanh_tien');
    // $sum_sp =$all_oder->sum('oder_soluong');

    // // Truyền ra view
    // $manager_oder = view('pages.checkout')
    //     ->with('all_oder', $all_oder)
    //     ->with('total', $total)
    //     ->with('sum_sp', $sum_sp);

    // return view("user_layout")->with('pages.checkout', $manager_oder);
    // }
     public function xu_ly_thanh_toan(){
        return  view('pages.checkout');
    }
    public function contact(){
        return view('pages.contact');
    }
    public function accoutn(){
        return view('pages.accoutn');
    }
    public function thong_bao(){
         if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
        }
        $all_oder = DB::table('tbl_oder')->orderByDesc('oder_id')->get();
        $manager_oder = view('pages.notification')->with('all_oder', $all_oder);
        return view("user_layout")->with('pages.notification',$manager_oder);
        // if ($result) {
        //     // Đăng nhập thành công
        //     session::put('stt', $value = 1);
        //     session::put('date', $value = $result->updated_at);
        //     session::put('message', 'Bạn có 1 đơn hàng được duyệt');
        //     // return Redirect::to('/trang-chu');
        //     return view("user_layout")->with('pages.notification',$manager_oder);
        // } else {
        //     // Đăng nhập thất bại
        //     session::put('message', 'Đơn hàng chưa được duyệt');
        //     // return Redirect::to('/thong-bao');
        //     return view("user_layout")->with('pages.notification',$manager_oder);
        // }
        // return view('pages.notification');
    }
     //LOGIN
     public function user_login(Request $request){

        $user_email = $request->user_email;
        // $user_password = $request->user_password;

        // $result = DB::table('users') ->where('email', $user_email) -> where('password', $user_password) -> first();
        // if ($result) {
        //     // Đăng nhập thành công
        //     session::put('user_name', $value = $result->name);
        //     session::put('user_id', $value = $result->id);
        //     return Redirect::to('/trang-chu')->with('message', 'Đăng nhập thành công!');
        // } else {
        //     // Đăng nhập thất bại
        //     session::put('message', 'Tên đăng nhập hoặc mật khẩu sai');
        //     return Redirect::to('/dang-nhap-dang-ky');
        // }
        $result = DB::table('users') ->where('email', $user_email) -> first();
         $credentials = [
        'email' => $request->user_email,
        'password' => $request->user_password,
    ];

    if (Auth::attempt($credentials)) {
        session::put('name_acoutn', $result->name);
        return redirect('/trang-chu')->with('message', 'Đăng nhập thành công!');
    } else {
        return redirect('/dang-nhap-dang-ky')->with('message', 'Sai tài khoản hoặc mật khẩu');
    }

    }
    //LOGUOT
    public function user_logout(){
        // session::put('user_name',null);
        // session::put('user_id',null);
        // return Redirect::to('/dang-nhap-dang-ky');
        session::put('name_acoutn', '');
        Auth::logout(); // ✅ Xóa thông tin đăng nhập
        return Redirect::to('/dang-nhap-dang-ky');
    }
      //REGISTER
      public function user_register(Request $request){
        $user_email = $request->user_email;
        $user_password = $request->user_password;

        $result = DB::table('users') ->where('email', $user_email) -> where('password', $user_password) -> first();
        if ($result) {
            // Đăng ký thất bại
            session::put('message', 'Tên đăng nhập trùng');
            return Redirect::to('/dang-nhap-dang-ky');

        } else {
            $data = array();
            $data['name'] = $request->user_name;
            $data['email'] = $request->user_email;
            $data['password'] = bcrypt($request->user_password);


            DB::table("users")->insert($data);
            Session::put("message", 'Đăng ký tài khoản thành công');
            return Redirect::to('/dang-nhap-dang-ky');
        }
    }
         //LOGIN
         public function thong_baoo(){
        //     $all_accoutn = DB::table('users')->get();
        //      $manager_accoutn = view('pages_admin.all_accoutn')->with('all_accoutn', $all_accoutn);
        // return view("admin_layout")->with('pages_admin.all_accoutn',$manager_accoutn);
            $result = DB::table('tbl_oder') ->where('oder_status', 1)-> first();
            if ($result) {
                // Đăng nhập thành công
                // session::put('date', $value = $result->updated_at);
                session::put('message', 'Bạn có 1 đơn hàng được duyệt');
                return Redirect::to('/trang-chu');
            } else {
                // Đăng nhập thất bại
                // session::put('message', 'Đơn hàng chưa được duyệt');
                // return Redirect::to('/thong-bao');
                // return view("pages.notification");
            }
        }


}
