<?php

// namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Http\Requests;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Redirect;

// class OderController extends Controller
// {
//     public function all_oder() {
//         $all_oder = DB::table('tbl_oder')->where('oder_status','!=','2')->orderByDesc('oder_id')->get();
//         $manager_oder = view('pages_admin.all_oder')->with('all_oder', $all_oder);
//         return view("admin_layout")->with('pages_admin.all_oder',$manager_oder);
//     }

//     public function detail_oder() {
//          if (!Auth::check()) {
//             return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để đặt hàng');
//         }
//         // $all_oder = DB::table('tbl_oder')->where('oder_status','!=','2')->orderByDesc('oder_id')->get();
//         // $manager_oder = view('pages.oder_history')->with('all_oder', $all_oder);
//         // //session()->put('thongbao', $dem-2);
//         // return view("user_layout")->with('oder_history',$manager_oder);

//         $id = Auth::id();
//         $all_oder = DB::table('tbl_oder')
//         ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
//         ->where('tbl_oder.oder_status', '!=','2')
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
//     $manager_oder = view('pages.oder_history')
//         ->with('all_oder', $all_oder)
//         ->with('total', $total)
//         ->with('sum_sp', $sum_sp);

//     return view("user_layout")->with('pages.oder_history', $manager_oder);
//     }
//     public function unactivate_category_product($category_product_id){
//         DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['oder_status'=>1]);
//         DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['updated_at'=>now()]);
//         Session::put("message_category_product", 'Duyệt đơn thành công');
//         return redirect("all-oder");
//     }
//     public function activate_category_product($category_product_id){
//         DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['oder_status'=>0]);
//         DB::table("tbl_oder")->where("oder_id",$category_product_id)->update(['updated_at'=>null]);
//         Session::put("message_category_product", 'Hủy duyệt đơn thành công');
//         return redirect("all-oder");
//     }
//     public function delete_oder($oder_id) {
//          DB::table("tbl_oder")->where("oder_id",$oder_id)->delete();

//         return redirect("lich-su-dat-hang")->with('message', 'Hủy đơn hàng thành công!');
//     }

// }





namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OderController extends Controller
{
    // =========================================================
    // ADMIN — Danh sách tất cả đơn hàng
    // GET /all-oder
    // =========================================================
    public function all_oder()
    {
        $all_oder = DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->join('users', 'tbl_oder.oder_id_user', '=', 'users.id')
            ->where('tbl_oder.oder_status', '!=', 2)
            ->orderByDesc('tbl_oder.oder_id')
            ->select(
                'tbl_oder.*',
                'tbl_product.product_name',
                'tbl_product.product_image',
                'tbl_product.product_price',
                'users.name as user_name',
                'users.email as user_email',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();

        $manager_oder = view('pages_admin.all_oder')->with('all_oder', $all_oder);
        return view('admin_layout')->with('pages_admin.all_oder', $manager_oder);
    }

    // =========================================================
    // ADMIN — Chi tiết 1 đơn hàng
    // GET /chi-tiet-oder/{oder_id}
    // =========================================================
    public function show_oder($oder_id)
    {
        $oder = DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->join('users', 'tbl_oder.oder_id_user', '=', 'users.id')
            ->where('tbl_oder.oder_id', $oder_id)
            ->select(
                'tbl_oder.*',
                'tbl_product.product_name',
                'tbl_product.product_image',
                'tbl_product.product_price',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->first();

        if (!$oder) {
            return redirect('all-oder')->with('error', 'Không tìm thấy đơn hàng!');
        }

        $manager_oder = view('pages_admin.detail_oder')->with('oder', $oder);
        return view('admin_layout')->with('pages_admin.detail_oder', $manager_oder);
    }

    // =========================================================
    // ADMIN — Form tạo đơn hàng thủ công (admin tạo hộ)
    // GET /them-oder
    // =========================================================
    public function add_oder()
    {
        $all_product = DB::table('tbl_product')->where('product_status', 1)->get();
        $all_user    = DB::table('users')->get();

        $manager = view('pages_admin.add_oder')
            ->with('all_product', $all_product)
            ->with('all_user', $all_user);

        return view('admin_layout')->with('pages_admin.add_oder', $manager);
    }

    // =========================================================
    // ADMIN — Lưu đơn hàng thủ công
    // POST /save-oder
    // =========================================================
    public function save_oder(Request $request)
    {
        $request->validate([
            'oder_id_user'    => 'required|exists:users,id',
            'oder_id_product' => 'required|exists:tbl_product,product_id',
            'oder_soluong'    => 'required|integer|min:1',
        ], [
            'oder_id_user.required'    => 'Vui lòng chọn khách hàng.',
            'oder_id_product.required' => 'Vui lòng chọn sản phẩm.',
            'oder_soluong.min'         => 'Số lượng phải ít nhất là 1.',
        ]);

        DB::table('tbl_oder')->insert([
            'oder_id_user'    => $request->oder_id_user,
            'oder_id_product' => $request->oder_id_product,
            'oder_soluong'    => $request->oder_soluong,
            'oder_status'     => 0, // Chờ xử lý
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        Session::put('message_oder', 'Tạo đơn hàng thành công!');
        return redirect('all-oder');
    }

    // =========================================================
    // ADMIN — Form sửa đơn hàng
    // GET /edit-oder/{oder_id}
    // =========================================================
    public function edit_oder($oder_id)
    {
        $oder = DB::table('tbl_oder')->where('oder_id', $oder_id)->first();

        if (!$oder) {
            return redirect('all-oder')->with('error', 'Không tìm thấy đơn hàng!');
        }

        $all_product = DB::table('tbl_product')->where('product_status', 1)->get();
        $all_user    = DB::table('users')->get();

        $manager = view('pages_admin.edit_oder')
            ->with('oder', $oder)
            ->with('all_product', $all_product)
            ->with('all_user', $all_user);

        return view('admin_layout')->with('pages_admin.edit_oder', $manager);
    }

    // =========================================================
    // ADMIN — Cập nhật đơn hàng
    // POST /update-oder/{oder_id}
    // =========================================================
    public function update_oder(Request $request, $oder_id)
    {
        $request->validate([
            'oder_soluong' => 'required|integer|min:1',
            'oder_status'  => 'required|in:0,1,3',
        ], [
            'oder_soluong.min'    => 'Số lượng phải ít nhất là 1.',
            'oder_status.in'      => 'Trạng thái không hợp lệ.',
        ]);

        DB::table('tbl_oder')->where('oder_id', $oder_id)->update([
            'oder_soluong' => $request->oder_soluong,
            'oder_status'  => $request->oder_status,
            'updated_at'   => now(),
        ]);

        Session::put('message_oder', 'Cập nhật đơn hàng thành công!');
        return redirect('all-oder');
    }

    // =========================================================
    // ADMIN — Duyệt đơn (status 0 → 1)
    // GET /duyet-oder/{oder_id}
    // =========================================================
    public function duyet_oder($oder_id)
    {
        DB::table('tbl_oder')->where('oder_id', $oder_id)->update([
            'oder_status' => 1,
            'updated_at'  => now(),
        ]);

        Session::put('message_oder', 'Duyệt đơn thành công!');
        return redirect('all-oder');
    }

    // =========================================================
    // ADMIN — Hủy duyệt đơn (status 1 → 0)
    // GET /huy-duyet-oder/{oder_id}
    // =========================================================
    public function huy_duyet_oder($oder_id)
    {
        DB::table('tbl_oder')->where('oder_id', $oder_id)->update([
            'oder_status' => 0,
            'updated_at'  => null,
        ]);

        Session::put('message_oder', 'Hủy duyệt đơn thành công!');
        return redirect('all-oder');
    }

    // =========================================================
    // ADMIN — Xóa đơn hàng
    // GET /delete-oder/{oder_id}
    // =========================================================


    // public function delete_oder($oder_id)
    // {
    //     DB::table('tbl_oder')->where('oder_id', $oder_id)->delete();
    //     Session::put('message_oder', 'Xóa đơn hàng thành công!');
    //     return redirect('all-oder');
    // }
     public function delete_oder($oder_id)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập');
        }

        $oder = DB::table('tbl_oder')
            ->where('oder_id', $oder_id)
            ->where('oder_id_user', Auth::id())
            ->first();

        if (!$oder) {
            return redirect('lich-su-dat-hang')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($oder->oder_status != 0) {
            return redirect('lich-su-dat-hang')->with('error', 'Đơn hàng đã được duyệt, không thể hủy!');
        }

        DB::table('tbl_oder')->where('oder_id', $oder_id)->delete();
        return redirect('lich-su-dat-hang')->with('message', 'Hủy đơn hàng thành công!');
    }

    // =========================================================
    // USER — Lịch sử đặt hàng của user đang đăng nhập
    // GET /lich-su-dat-hang
    // =========================================================
    public function detail_oder()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập để xem đơn hàng');
        }

        $user_id = Auth::id();

    $orders = DB::table('tbl_order_main')
        ->where('user_id',$user_id)
        ->orderByDesc('order_id')
        ->get();

    return view('pages.oder_history', compact('orders'));
    }

    public function chi_tiet_don($id){

    $details = DB::table('tbl_oder')
        ->join('tbl_product','tbl_oder.oder_id_product','=','tbl_product.product_id')
        ->where('order_id',$id)
        ->select(
            'tbl_product.product_name',
            'tbl_product.product_price',
            'tbl_oder.oder_soluong',
            DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
        )
        ->get();

    return view('pages.order_detail', compact('details'));
}

    // =========================================================
    // USER — Hủy đơn hàng (chỉ được hủy khi status = 0)
    // GET /huy-don-hang/{oder_id}
    // =========================================================
    public function user_cancel_oder($oder_id)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('error', 'Bạn cần đăng nhập');
        }

        $oder = DB::table('tbl_oder')
            ->where('oder_id', $oder_id)
            ->where('oder_id_user', Auth::id())
            ->first();

        if (!$oder) {
            return redirect('lich-su-dat-hang')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($oder->oder_status != 0) {
            return redirect('lich-su-dat-hang')->with('error', 'Đơn hàng đã được duyệt, không thể hủy!');
        }

        DB::table('tbl_oder')->where('oder_id', $oder_id)->delete();
        return redirect('lich-su-dat-hang')->with('message', 'Hủy đơn hàng thành công!');
    }
}
