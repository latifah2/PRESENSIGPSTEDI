<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(request $request)
    {
        // $checkKaryawan = Karyawan::where('nim', $request->nim)
        // ->where('password', $request->password)->get()->count();

        $checkAuth = Auth::guard('karyawan')->attempt(['nim' => $request->nim, 'password' => $request->password]);
        if ($checkAuth) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['massage' => 'NIM / Password salah']);
        }
    }

    public function proseslogout()
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::logout();
            return redirect('/');
        }
    }
}
