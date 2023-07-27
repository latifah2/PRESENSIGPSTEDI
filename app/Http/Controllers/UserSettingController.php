<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSettingController extends Controller
{
    public function index()
    {
        $id = Auth::guard('userAuthentication')->user()->id;
        return view('presensi.usersetting', [
            'listUserTamu' => DB::table('karyawan')->where('user_status', 'Guest')->orderBy('id')->get()
        ]);
    }
}
