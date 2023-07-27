<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CutiController extends Controller
{
    public function cuti()
    {
        $idKaryawan = Auth::guard('userAuthentication')->user()->id;
        $data['listCuti'] = DB::table('cuti')->where('id_karyawan',$idKaryawan )->get();
        return view('cuti.cuti', $data);
    }

    public function saveCuti(Request $request)
    {
        $dataUserLogin = Auth::guard('userAuthentication')->user();
        $filename = 'form-cuti-'.time().'-'.$dataUserLogin->nim.'.pdf';

        //upload file cuti
        $folderPath = "public/upload/cuti/";
        $fileCuti = $request->file('file_cuti');
        $fileCuti->move($folderPath, $filename);

        $data = [
            'id_karyawan' => $dataUserLogin->id,
            'file_cuti' => $filename,
            'status' => 'pending', // pending, approved, rejected,
            'created_at' => date('Y-m-d H:i:s'),
            'tanggal_izin' => $request->tanggal_izin 
        ];
        $simpan = DB::table('cuti')->insert($data);
        if ($simpan) {
            return redirect('/cuti');
        }else{
            echo 'gagal';
        }
    }
}
