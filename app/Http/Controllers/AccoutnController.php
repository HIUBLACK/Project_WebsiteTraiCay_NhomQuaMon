<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccoutnController extends Controller
{
    public function all_accoutn()
    {
        $all_accoutn = DB::table('users')->orderByDesc('id')->get();
        return view('pages_admin.all_accoutn', compact('all_accoutn'));
    }

    public function edit_accoutn($id)
    {
        $account = DB::table('users')->where('id', $id)->first();
        if (!$account) {
            return redirect('/all-taikhoan')->with('message', 'Không tìm thấy tài khoản');
        }

        return view('pages_admin.edit_accoutn', compact('account'));
    }

    public function update_accoutn(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $id,
        ]);

        $account = DB::table('users')->where('id', $id)->first();
        if (!$account) {
            return redirect('/all-taikhoan')->with('message', 'Không tìm thấy tài khoản');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|max:50|confirmed',
            ]);
            $data['password'] = bcrypt($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect('/all-taikhoan')->with('message', 'Cập nhật tài khoản thành công');
    }
    //Thêm tài khoản admin
    public function add_accoutn(){
        return view('pages_admin.add_accoutn');
    }

    public function save_accoutn(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|max:50|confirmed',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rank' => 'Thường',
            'total_spent' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/all-taikhoan')->with('message', 'Thêm tài khoản thành công');

    }
    //Thông tin tài khoản user
    public function user_thong_tin()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập để xem thông tin tài khoản');
        }

        $user = DB::table('users')->where('id', Auth::id())->first();
        return view('pages.edit_accoutn', compact('user'));
    }

    public function user_doi_mat_khau()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập để đổi mật khẩu');
        }

        return view('pages.edit_password');
    }

    public function user_update_thong_tin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập');
        }

        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        DB::table('users')->where('id', Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => now(),
        ]);

        session()->put('name_acoutn', $request->name);

        return redirect('/user-thong-tin')->with('message', 'Cập nhật hồ sơ thành công');
    }

    public function user_update_mat_khau(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập');
        }

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|max:50|confirmed',
        ]);

        $user = DB::table('users')->where('id', Auth::id())->first();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return redirect('/user-doi-mat-khau')->with('message', 'Mật khẩu hiện tại không đúng');
        }

        DB::table('users')->where('id', Auth::id())->update([
            'password' => bcrypt($request->password),
            'updated_at' => now(),
        ]);

        return redirect('/user-doi-mat-khau')->with('message', 'Đổi mật khẩu thành công');
    }

    public function show_forgot_password_form(Request $request)
    {
        return view('pages.forgot_password', [
            'email' => $request->email,
        ]);
    }

    public function send_reset_password_otp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email chưa được đăng ký trong hệ thống.',
        ]);

        $email = $request->email;
        $otp = (string) random_int(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($otp . '|' . Str::lower($email)),
                'created_at' => now(),
            ]
        );

        try {
            Mail::raw(
                "Ma xac thuc dat lai mat khau cua ban la: {$otp}. Ma co hieu luc trong 15 phut.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Ma xac thuc dat lai mat khau');
                }
            );
        } catch (\Throwable $exception) {
            return redirect('/quen-mat-khau')->with('message', 'Không gửi được email. Hãy kiểm tra cấu hình MAIL trong file .env');
        }

        return redirect('/dat-lai-mat-khau?email=' . urlencode($email))
            ->with('message', 'Đã gửi mã xác thực về email');
    }

    public function show_reset_password_form(Request $request)
    {
        return view('pages.reset_password', [
            'email' => $request->email,
        ]);
    }

    public function reset_password_with_otp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:6|max:50|confirmed',
        ]);

        $reset = DB::table('password_resets')->where('email', $request->email)->first();
        if (!$reset) {
            return redirect('/quen-mat-khau')->with('message', 'Mã xác thực không tồn tại hoặc đã hết hạn');
        }

        if (Carbon::parse($reset->created_at)->addMinutes(15)->lt(now())) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect('/quen-mat-khau')->with('message', 'Mã xác thực đã hết hạn');
        }

        $validOtp = Hash::check($request->otp . '|' . Str::lower($request->email), $reset->token);
        if (!$validOtp) {
            return redirect('/dat-lai-mat-khau?email=' . urlencode($request->email))
                ->with('message', 'Mã xác thực không đúng');
        }

        DB::table('users')->where('email', $request->email)->update([
            'password' => bcrypt($request->password),
            'updated_at' => now(),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/dang-nhap-dang-ky')->with('message', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}
