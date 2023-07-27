<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(request $request)
    {
        $checkAuth = Auth::guard('userAuthentication')->attempt(['nim' => $request->nim, 'password' => $request->password]);
        if ($checkAuth) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['massage' => 'NIM / Password salah']);
        }
    }

    public function proseslogout()
    {
        if (Auth::guard('userAuthentication')->check()) {
            Auth::logout();
            return redirect('/');
        }
    }
}
