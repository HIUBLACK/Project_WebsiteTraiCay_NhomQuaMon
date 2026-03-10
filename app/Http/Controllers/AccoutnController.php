<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AccoutnController extends Controller
{
      //HIỂN THỊ DANH SÁCH TÀI KHOẢN USER
      public function all_accoutn(){
        $all_accoutn = DB::table('users')->get();
        $manager_accoutn = view('pages_admin.all_accoutn')->with('all_accoutn', $all_accoutn);
        return view("admin_layout")->with('pages_admin.all_accoutn',$manager_accoutn);

    }
    //END
}
