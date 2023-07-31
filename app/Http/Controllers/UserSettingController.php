<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserSettingController extends Controller
{
    public function index()
    {
        $id = Auth::guard('userAuthentication')->user()->id;
        return view('presensi.usersetting', [
            'listUserTamu' => DB::table('karyawan')->where('user_status', 'Guest')->orderBy('id')->get()
        ]);
    }

    public function add(Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $email = $request->email;
        $jabatan = $request->jabatan;
        $password = Hash::make(123456);

        $data = [
        'nim' => $nim,
        'nama_lengkap' => $nama_lengkap,
        'no_hp' => $no_hp,
        'jabatan' => $jabatan,
        'password' => $password,
        'user_status' => 'Guest'
        ];

        $simpanKeTableKaryawan = Karyawan::create($data);

        /**
         * insert to table users
         * to save email user
         */
        $simpanKeTabelUsers = User::create([
            'email' => $email,
            'name' => $nama_lengkap,
            'password' => $password,
            'id_karyawan' => $simpanKeTableKaryawan->id
        ]);

        if ($simpanKeTableKaryawan){
            if ($simpanKeTabelUsers) {
                return Redirect::back()->with(['success' => 'Data User Berhasil di simpan']);
            }else{
                return Redirect::back()->with(['success' => 'Data User Berhasil di simpan. Data email gagal di simpan']);
            }
        }else {
            return Redirect::back()->with(['error' => 'Data User Gagal di simpan']);
        }

    }
    

}
