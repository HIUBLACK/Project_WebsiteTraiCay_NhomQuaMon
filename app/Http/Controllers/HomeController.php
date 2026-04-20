<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Http\Requests;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Auth;
// use Termwind\Components\Raw;

// class HomeController extends Controller
// {
//     public function user(){
//         $all_category_product = DB::table('tbl_category_product')->get();
//         $all_product = DB::table('tbl_product')->get();
//         $manager_category_product = view('pages.home')->with('all_category_product', $all_category_product)->with('all_product', $all_product);
//         // $manager_product = view('pages.product')->with('all_product', $all_product);
//         return view("user_layout")->with('pages.home',$manager_category_product);

//         // return view('pages.home');
//     }
//     public function cart(Request $request,$product_id){
//         if (!Auth::check()) {
//             return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//         }
//         $result = DB::table("tbl_oder")->where("oder_id_product",$product_id)->where('oder_status','=','2')->first();
//         $data = array();
//         if($result){
//             $sl =  $result->oder_soluong + 1;

//             $data['oder_soluong'] = $sl;
//              DB::table("tbl_oder")->where('oder_id','=',$result->oder_id)->update($data);

//         }else{

//             $data['oder_soluong'] = '1';

//             $data['oder_status'] = '2';
//             $data['oder_id_user'] = Auth::id();
//             $data['oder_id_product'] = $product_id;
//             DB::table("tbl_oder")->insert($data);

//         }



//         return redirect("/gio-hang");

//     }
//     //THEM GIỎ HÀNG
//     public function gio_hang(){
//         if (!Auth::check()) {
//             return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//         }

//         $id = Auth::id();
//         $all_oder = DB::table('tbl_oder')
//         ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
//         ->where('tbl_oder.oder_status', 2)
//         ->where('tbl_oder.oder_id_user', $id)
//         ->orderByDesc('tbl_oder.oder_id')
//         ->select(
//             'tbl_oder.*',
//             'tbl_product.product_image',
//             'tbl_product.product_name',
//             'tbl_product.product_price',
//             DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
//         )
//         ->get();

//     // Tính tổng tiền tất cả đơn hàng

//     $total = $all_oder->sum('thanh_tien');
//     $sum_sp =$all_oder->sum('oder_soluong');

//     // Truyền ra view
//     $manager_oder = view('pages.cart')
//         ->with('all_oder', $all_oder)
//         ->with('total', $total)
//         ->with('sum_sp', $sum_sp);

//     return view("user_layout")->with('pages.cart', $manager_oder);


//     }
//     //Update giỏ hàng
//     public function update_gio_hang(Request $request,$oder_id){
//         if (!Auth::check()) {
//             return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//         }
//         $data = array();
//         $action = $request->input('action');
//         $TongSL = $request->input('soluong');
//         if($action =='giam'){
//             $data['oder_soluong'] = $TongSL ;
//         }else{
//             $data['oder_soluong'] = $TongSL ;
//         }

//         DB::table("tbl_oder")->where("oder_id",$oder_id)->update($data);
//         return redirect("/gio-hang");
//     }
//     //Xóa giỏ hàng
//      public function delete_gio_hang(Request $request,$oder_id){
//        DB::table("tbl_oder")->where("oder_id",$oder_id)->delete();
//         return redirect("/gio-hang");


//     }

//     // public function checkout(){
//     //      if (!Auth::check()) {
//     //         return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//     //     }
//     //     $id = Auth::id();
//     //     $all_oder = DB::table('tbl_oder')
//     //     ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
//     //     ->where('tbl_oder.oder_status', 2)
//     //     ->where('tbl_oder.oder_id_user', $id)
//     //     ->orderByDesc('tbl_oder.oder_id')
//     //     ->select(
//     //         'tbl_oder.*',
//     //         'tbl_product.product_image',
//     //         'tbl_product.product_name',
//     //         'tbl_product.product_price',
//     //         DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
//     //     )
//     //     ->get();

//     // // Tính tổng tiền tất cả đơn hàng

//     // $total = $all_oder->sum('thanh_tien');
//     // $sum_sp =$all_oder->sum('oder_soluong');

//     // // Truyền ra view
//     // $manager_oder = view('pages.checkout')
//     //     ->with('all_oder', $all_oder)
//     //     ->with('total', $total)
//     //     ->with('sum_sp', $sum_sp);

//     // return view("user_layout")->with('pages.checkout', $manager_oder);
//     // }
//      public function xu_ly_thanh_toan(){
//         return  view('pages.checkout');
//     }
//     public function contact(){
//         return view('pages.contact');
//     }
//     public function accoutn(){
//         return view('pages.accoutn');
//     }
//     public function thong_bao(){
//          if (!Auth::check()) {
//             return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//         }
//         $all_oder = DB::table('tbl_oder')->orderByDesc('oder_id')->get();
//         $manager_oder = view('pages.notification')->with('all_oder', $all_oder);
//         return view("user_layout")->with('pages.notification',$manager_oder);
//         // if ($result) {
//         //     // Đăng nhập thành công
//         //     session::put('stt', $value = 1);
//         //     session::put('date', $value = $result->updated_at);
//         //     session::put('message', 'Bạn có 1 đơn hàng được duyệt');
//         //     // return Redirect::to('/trang-chu');
//         //     return view("user_layout")->with('pages.notification',$manager_oder);
//         // } else {
//         //     // Đăng nhập thất bại
//         //     session::put('message', 'Đơn hàng chưa được duyệt');
//         //     // return Redirect::to('/thong-bao');
//         //     return view("user_layout")->with('pages.notification',$manager_oder);
//         // }
//         // return view('pages.notification');
//     }
//      //LOGIN
//      public function user_login(Request $request){

//         $user_email = $request->user_email;
//         // $user_password = $request->user_password;

//         // $result = DB::table('users') ->where('email', $user_email) -> where('password', $user_password) -> first();
//         // if ($result) {
//         //     // Đăng nhập thành công
//         //     session::put('user_name', $value = $result->name);
//         //     session::put('user_id', $value = $result->id);
//         //     return Redirect::to('/trang-chu')->with('message', 'Đăng nhập thành công!');
//         // } else {
//         //     // Đăng nhập thất bại
//         //     session::put('message', 'Tên đăng nhập hoặc mật khẩu sai');
//         //     return Redirect::to('/dang-nhap-dang-ky');
//         // }
//         $result = DB::table('users') ->where('email', $user_email) -> first();
//          $credentials = [
//         'email' => $request->user_email,
//         'password' => $request->user_password,
//     ];

//     if (Auth::attempt($credentials)) {
//         session::put('name_acoutn', $result->name);
//         return redirect('/trang-chu')->with('message', 'Đăng nhập thành công!');
//     } else {
//         return redirect('/dang-nhap-dang-ky')->with('message', 'Sai tài khoản hoặc mật khẩu');
//     }

//     }
//     //LOGUOT
//     public function user_logout(){
//         // session::put('user_name',null);
//         // session::put('user_id',null);
//         // return Redirect::to('/dang-nhap-dang-ky');
//         session::put('name_acoutn', '');
//         Auth::logout(); // ✅ Xóa thông tin đăng nhập
//         return Redirect::to('/dang-nhap-dang-ky');
//     }
//       //REGISTER
//       public function user_register(Request $request){
//         $user_email = $request->user_email;
//         $user_password = $request->user_password;

//         $result = DB::table('users') ->where('email', $user_email) -> where('password', $user_password) -> first();
//         if ($result) {
//             // Đăng ký thất bại
//             session::put('message', 'Tên đăng nhập trùng');
//             return Redirect::to('/dang-nhap-dang-ky');

//         } else {
//             $data = array();
//             $data['name'] = $request->user_name;
//             $data['email'] = $request->user_email;
//             $data['password'] = bcrypt($request->user_password);


//             DB::table("users")->insert($data);
//             Session::put("message", 'Đăng ký tài khoản thành công');
//             return Redirect::to('/dang-nhap-dang-ky');
//         }
//     }
//          //LOGIN
//          public function thong_baoo(){
//         //     $all_accoutn = DB::table('users')->get();
//         //      $manager_accoutn = view('pages_admin.all_accoutn')->with('all_accoutn', $all_accoutn);
//         // return view("admin_layout")->with('pages_admin.all_accoutn',$manager_accoutn);
//             $result = DB::table('tbl_oder') ->where('oder_status', 1)-> first();
//             if ($result) {
//                 // Đăng nhập thành công
//                 // session::put('date', $value = $result->updated_at);
//                 session::put('message', 'Bạn có 1 đơn hàng được duyệt');
//                 return Redirect::to('/trang-chu');
//             } else {
//                 // Đăng nhập thất bại
//                 // session::put('message', 'Đơn hàng chưa được duyệt');
//                 // return Redirect::to('/thong-bao');
//                 // return view("pages.notification");
//             }
//         }


// }





namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    private function getActiveProductForCart($productId)
    {
        return DB::table('tbl_product')
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->first();
    }

    private function couponAppliesToUser($couponId, $user)
    {
        $userList = DB::table('tbl_coupon_user')
            ->where('coupon_id', $couponId)
            ->pluck('user_id')
            ->toArray();

        if (count($userList) > 0 && !in_array($user->id, $userList)) {
            return false;
        }

        $rankList = DB::table('tbl_coupon_rank')
            ->where('coupon_id', $couponId)
            ->pluck('rank')
            ->toArray();

        if (count($rankList) > 0 && !in_array($user->rank, $rankList)) {
            return false;
        }

        return true;
    }

    private function couponAppliesToProduct($coupon, $productId)
    {
        if ((int) $coupon->coupon_scope !== 2) {
            return true;
        }

        return DB::table('tbl_coupon_product')
            ->where('coupon_id', $coupon->coupon_id)
            ->where('product_id', $productId)
            ->exists();
    }

    private function validateCouponForCart($coupon, $user, $cartItems)
    {
        if (!$coupon) {
            return false;
        }

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry)) {
            return false;
        }

        if ($coupon->coupon_usage_limit > 0 && $coupon->coupon_used_count >= $coupon->coupon_usage_limit) {
            return false;
        }

        if (!$this->couponAppliesToUser($coupon->coupon_id, $user)) {
            return false;
        }

        if ($cartItems->isEmpty()) {
            return false;
        }

        $total = 0;
        $quantity = 0;
        $hasApplicableProduct = false;

        foreach ($cartItems as $item) {
            $total += $item->product_price * $item->oder_soluong;
            $quantity += $item->oder_soluong;

            if ($this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                $hasApplicableProduct = true;
            }
        }

        if ((int) $coupon->coupon_scope === 2 && !$hasApplicableProduct) {
            return false;
        }

        $cond = DB::table('tbl_coupon_conditions')
            ->where('coupon_id', $coupon->coupon_id)
            ->first();

        if ($cond) {
            if ($cond->min_order_value && $total < $cond->min_order_value) {
                return false;
            }

            if ($cond->min_order_quantity && $quantity < $cond->min_order_quantity) {
                return false;
            }
        }

        return true;
    }

    // Trang chủ
    public function user()
    {
        $all_category_product = DB::table('tbl_category_product')->get();
        $all_product = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->get();
        $manager_category_product = view('pages.home')
            ->with('all_category_product', $all_category_product)
            ->with('all_product', $all_product);
        return view('user_layout')->with('pages.home', $manager_category_product);
    }

    // =========================================================
    // ĐĂNG KÝ
    // =========================================================
    public function user_register(Request $request)
    {
        $request->validate([
            'user_name'             => 'required|string|min:2|max:100',
            'user_email'            => 'required|email|max:150|unique:users,email',
            'user_password'         => 'required|string|min:6|max:50',
           // 'user_password_confirm' => 'required|same:user_password',
        ], [
            'user_name.required'             => 'Họ tên không được để trống.',
            'user_name.min'                  => 'Họ tên phải có ít nhất 2 ký tự.',
            'user_email.required'            => 'Email không được để trống.',
            'user_email.email'               => 'Email không đúng định dạng.',
            'user_email.unique'              => 'Email này đã được đăng ký.',
            'user_password.required'         => 'Mật khẩu không được để trống.',
            'user_password.min'              => 'Mật khẩu phải có ít nhất 6 ký tự.',
          //  'user_password_confirm.required' => 'Vui lòng xác nhận mật khẩu.',
           // 'user_password_confirm.same'     => 'Xác nhận mật khẩu không khớp.',
        ]);

        DB::table('users')->insert([
            'name'     => $request->user_name,
            'email'    => $request->user_email,

            'password' => bcrypt($request->user_password),
            'created_at' => now(),
        ]);

        Session::put('message', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập.');
        return Redirect::to('/dang-nhap-dang-ky');
    }

    // =========================================================
    // ĐĂNG NHẬP
    // =========================================================
    public function user_login(Request $request)
    {
        $request->validate([
            'user_email'    => 'required|email',
            'user_password' => 'required|string|min:6',
        ], [
            'user_email.required'    => 'Email không được để trống.',
            'user_email.email'       => 'Email không đúng định dạng.',
            'user_password.required' => 'Mật khẩu không được để trống.',
            'user_password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $credentials = [
            'email'    => $request->user_email,
            'password' => $request->user_password,
        ];

        if (Auth::attempt($credentials)) {
            $result = DB::table('users')->where('email', $request->user_email)->first();
            Session::put('name_acoutn', $result->name);
            return redirect('/trang-chu')->with('message', 'Đăng nhập thành công!');
        }

        return redirect('/dang-nhap-dang-ky')->with('message', 'Sai email hoặc mật khẩu.');
    }

    // ĐĂNG XUẤT
    public function user_logout()
    {

        Session::put('name_acoutn', '');
        Auth::logout();
        return Redirect::to('/dang-nhap-dang-ky');
    }

    // =========================================================
    // GIỎ HÀNG — Thêm sản phẩm
    // =========================================================
    public function cart(Request $request, $product_id)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng.');
        }

        // Kiểm tra product_id hợp lệ
        $product = $this->getActiveProductForCart($product_id);
        if (!$product) {
            return redirect('/san-pham')->with('error', 'Sản phẩm hiện không khả dụng.');
        }

        $user_id = Auth::id();

        // FIX: thêm filter theo oder_id_user để tránh nhầm giỏ hàng giữa các user
        $result = DB::table('tbl_oder')
            ->where('oder_id_product', $product_id)
            ->where('oder_id_user', $user_id)
            ->where('oder_status', 2)
            ->first();

        if ($result) {
            if ((int) $result->oder_soluong + 1 > (int) $product->stock_quantity) {
                return redirect('/gio-hang')->with('error', 'Số lượng sản phẩm quá số tồn kho');
            }

            DB::table('tbl_oder')
                ->where('oder_id', $result->oder_id)
                ->update([
                    'oder_soluong' => $result->oder_soluong + 1,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('tbl_oder')->insert([
                'oder_soluong'    => 1,
                'oder_status'     => 2,
                'oder_id_user'    => $user_id,
                'oder_id_product' => $product_id,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        return redirect('/gio-hang')->with('message', 'Thêm sản phẩm vào giỏ hàng thành công!');

    }

    // =========================================================
    // GIỎ HÀNG — Hiển thị
    // =========================================================
    public function gio_hang()
{
    if (!Auth::check()) {
        return redirect('/dang-nhap-dang-ky')
            ->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
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
            'tbl_product.stock_quantity',
            DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
        )
        ->get();

    $total   = $all_oder->sum('thanh_tien');
    $sum_sp  = $all_oder->sum('oder_soluong');

    // =========================
    // 🔥 THÊM LOGIC COUPON
    // =========================
    $discount = 0;
    $coupons = [];
    $coupon = Session::get('coupon', null);
    $user = DB::table('users')->where('id', $id)->first();

    if ($coupon && $user && $this->validateCouponForCart($coupon, $user, $all_oder)) {
        $coupons[] = $coupon;
        foreach ($all_oder as $item) {

            $price = $item->product_price;
            $qty   = $item->oder_soluong;

            if ($this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                if ($coupon->coupon_type == 1) {
                    $discount += ($price * $qty * $coupon->coupon_value) / 100;
                } else {
                    $discount += $coupon->coupon_value;
                }
            }
        }
    } elseif ($coupon) {
        Session::forget('coupon');

    }

    $total_after = max(0, $total - $discount);

    // =========================
    // TRUYỀN VIEW
    // =========================
    $manager_oder = view('pages.cart')
        ->with('all_oder', $all_oder)
        ->with('total', $total)
        ->with('sum_sp', $sum_sp)
        ->with('discount', $discount)
        ->with('total_after', $total_after)
        ->with('coupons', $coupons)
        ->with('coupons_db', []); // Đảm bảo luôn có biến coupons_db

    return view('user_layout')->with('pages.cart', $manager_oder);

}

    // =========================================================
    // GIỎ HÀNG — Cập nhật số lượng
    // =========================================================
    public function update_gio_hang(Request $request, $oder_id)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập.');
        }

        $request->validate([
            'soluong' => 'required|integer|min:1|max:100',
            'action'  => 'required|in:tang,giam',
        ], [
            'soluong.required' => 'Số lượng không được để trống.',
            'soluong.integer'  => 'Số lượng phải là số nguyên.',
            'soluong.min'      => 'Số lượng phải ít nhất là 1.',
            'soluong.max'      => 'Số lượng không được quá 100.',
            'action.in'        => 'Hành động không hợp lệ.',
        ]);

        // Kiểm tra oder_id thuộc về user hiện tại
        $oder = DB::table('tbl_oder')
            ->where('oder_id', $oder_id)
            ->where('oder_id_user', Auth::id())
            ->where('oder_status', 2)
            ->first();

        if (!$oder) {
            return redirect('/gio-hang')->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
        }

        $product = $this->getActiveProductForCart($oder->oder_id_product);
        if (!$product) {
            return redirect('/gio-hang')->with('error', 'Sản phẩm hiện không khả dụng.');
        }

        if ((int) $request->soluong > (int) $product->stock_quantity) {
            return redirect('/gio-hang')->with('error', 'Số lượng sản phẩm quá số tồn kho');
        }

        DB::table('tbl_oder')
            ->where('oder_id', $oder_id)
            ->update([
                'oder_soluong' => $request->soluong,
                'updated_at' => now(),
            ]);

        return redirect('/gio-hang');

    }

    // =========================================================
    // GIỎ HÀNG — Xóa sản phẩm
    // =========================================================
    public function delete_gio_hang(Request $request, $oder_id)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập.');
        }

        // Chỉ cho xóa item của chính user đó
        $deleted = DB::table('tbl_oder')
            ->where('oder_id', $oder_id)
            ->where('oder_id_user', Auth::id())
            ->delete();

        if (!$deleted) {
            return redirect('/gio-hang')->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
        }

        return redirect('/gio-hang');
    }

    // Liên hệ
    public function contact()
    {
        return view('pages.contact');
    }

    // Trang đăng nhập / đăng ký
    public function accoutn()
    {
        return view('pages.accoutn');
    }

    // Thông báo
    public function thong_bao()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập.');
        }

        $notifications = DB::table('tbl_order_main')
            ->where('user_id', Auth::id())
            ->orderByDesc('order_id')
            ->select(
                'order_id',
                'status',
                'payment_status',
                'payment_method',
                'created_at',
                'cancelled_at',
            )
            ->get();

        $manager_oder = view('pages.notification')->with('notifications', $notifications);
        return view('user_layout')->with('pages.notification', $manager_oder);
    }

    public function google_redirect()
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');

        if (!$clientId || !$redirectUri) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Chưa cấu hình GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI trong .env');
        }

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function google_callback(Request $request)
    {
        if ($request->filled('error')) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Đăng nhập Google đã bị hủy');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        if (!$clientId || !$clientSecret || !$redirectUri) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Chưa cấu hình đăng nhập Google trong .env');
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $request->code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if (!$tokenResponse->successful()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Không lấy được token đăng nhập Google');
        }

        $accessToken = $tokenResponse->json('access_token');
        $profileResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v2/userinfo');

        if (!$profileResponse->successful()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Không lấy được thông tin người dùng Google');
        }

        $googleUser = $profileResponse->json();
        $email = $googleUser['email'] ?? null;

        if (!$email) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Tài khoản Google không có email hợp lệ');
        }

        $user = DB::table('users')
            ->where('google_id', $googleUser['id'] ?? '')
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            DB::table('users')->where('id', $user->id)->update([
                'name' => $googleUser['name'] ?? $user->name,
                'google_id' => $googleUser['id'] ?? $user->google_id,
                'avatar' => $googleUser['picture'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?: now(),
                'updated_at' => now(),
            ]);

            $userId = $user->id;
        } else {
            $userId = DB::table('users')->insertGetId([
                'name' => $googleUser['name'] ?? 'Google User',
                'email' => $email,
                'google_id' => $googleUser['id'] ?? null,
                'avatar' => $googleUser['picture'] ?? null,
                'rank' => 'Thường',
                'total_spent' => 0,
                'password' => bcrypt(Str::random(32)),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Auth::loginUsingId($userId, true);
        $authUser = DB::table('users')->where('id', $userId)->first();
        session()->put('name_acoutn', $authUser->name);

        return redirect('/trang-chu')->with('message', 'Đăng nhập Google thành công');
    }

}
