<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'rank' => 'nullable|string|max:50',
            'total_spent' => 'nullable|numeric|min:0',
        ]);

        $account = DB::table('users')->where('id', $id)->first();
        if (!$account) {
            return redirect('/all-taikhoan')->with('message', 'Không tìm thấy tài khoản');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rank' => $request->rank ?: $account->rank,
            'total_spent' => $request->total_spent ?? $account->total_spent,
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
}
