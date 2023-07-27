<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function profile()
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        return view('presensi.profile', [
            'karyawan' => DB::table('karyawan')->where('nim',$nim)->first()
        ]);
    }

    public function editprofile()
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        return view('presensi.editprofile', [
            'karyawan' => DB::table('karyawan')->where('nim',$nim)->first()
        ]);
    }

    public function updateprofile(Request $request)
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $jabatan = $request->jabatan;
        $password = Hash::make($request->password);
    
        if(!empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan,
                'password' => $password
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'jabatan' => $jabatan
            ];
        }

        /**
         * update profile if exist
         */
        $profileImage = $request->file('image_profile');
        if (!empty($profileImage)) {
            $getExtentionFile = $profileImage->extension();
            $filename = 'image_profile_'.time().'-'.$nim.'.'.$getExtentionFile;

            $data['image_profile'] = $filename;
            $folderPath = "public/upload/imageprofile/";

            /**
             * hapus file yg sudah ada
             */
            $imageProfileLogin = Auth::guard('userAuthentication')->user()->image_profile;
            if (!empty($imageProfileLogin) && file_exists($folderPath.$imageProfileLogin)) {
                unlink($folderPath.$imageProfileLogin);
            }
            $profileImage->move($folderPath, $filename);
            
        }

        $update = DB::table('karyawan')->where('nim', $nim)->update($data);
        if ($update){
            return Redirect::back()->with(['success' => 'Data Berhasil di Update']);
        }else {
            return Redirect::back()->with(['error' => 'Data Gagal di Update']);
        }
    }

    // public function imageprofil()
    // {
    //     $dataUserLogin = Auth::guard('userAuthentication')->user();
    //     $filename = 'image_profile'.time().'-'.$dataUserLogin->nim.'.jpg';

    //     //upload file cuti
    //     $folderPath = "public/upload/imageprofile/";
    //     $fileImage = $request->file('image_profile');
    //     $fileImage->move($folderPath, $filename);

    //     $data = [
    //         'file_c' => $filename,
    //         'created_at' => date('Y-m-d H:i:s')
    //     ];
    //     $simpan = DB::table('karyawan')->where('id',$dataUserLogin->id)->update($data);
    //     if ($simpan) {
    //         return redirect('/profile');
    //     }else{
    //         echo 'gagal';
    //     }
    // }

}
