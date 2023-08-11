<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class CutiController extends Controller
{
    public function cuti()
    {
        $idKaryawan = Auth::guard('userAuthentication')->user()->id;
        //listcuti menampung data cuti berdasarkan id karyawan 
        $data['listCuti'] = DB::table('cuti')->where('id_karyawan',$idKaryawan )->get();
        //jika yang login admin 
        //select : ambil semua data di tabel cuti dan data kolom nama lengkap dari tabel karyawan dengan 
        //menggabungkan dua tabel cuti dan karyawan menggunakan id.
        if (Auth::guard('userAuthentication')->user()->user_status != 'Guest') {
            $data['listCuti'] = DB::table('cuti')
            ->select('cuti.*', 'karyawan.nama_lengkap')
            ->leftJoin('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            ->orderBy('created_at')
            ->get();
        }
        return view('cuti.cuti', $data);
    }

    public function saveCuti(Request $request)
    {
        $dataUserLogin = Auth::guard('userAuthentication')->user();
        //Mail::to($request->user())->send(new SendEmail($fileCuti));
        $filename = 'form-cuti-'.time().'-'.$dataUserLogin->nim.'.pdf';
        //default status
        $status = 'pending';
        
        $data = [
            'id_karyawan' => $dataUserLogin->id,
            //'nama_lengkap' => $dataUserLogin->nama_lengkap,
            'file_cuti' => $filename,
            'status' => $status, // pending, approved, rejected,
            'created_at' => date('Y-m-d H:i:s'),
            'tanggal_izin' => $request->tanggal_izin 
        ];

        if (Auth::guard('userAuthentication')->user()->user_status == 'Guest') {
        //upload file cuti
            $folderPath = "public/upload/cuti/";
            $fileCuti = $request->file('file_cuti');
            $fileCuti->move($folderPath, $filename);

            // $request->file('file_cuti')->storeAs($folderPath, $filename);
            // $fileCuti = storage_path("app/{$folderPath}{$filename}");
            // Mail::to('admin@example.com')->send(new SendEmail($fileCuti));
            // Jika user adalah 'Guest', maka statusnya pending

            $simpan = DB::table('cuti')->insert($data);
            if ($simpan) {
                return redirect('/cuti');
            }else{
                echo 'gagal';
            }
        }
    }

    public function updateStatusCuti(Request $request)
    {
        $update = DB::table('cuti')->where('id', $request->id)->update([
            'status' => $request->status
        ]);
        if ($update) {
            return redirect('/cuti');
        }else {
            echo "gagal melakukan update status ".$request->status." cuti, kemungkinan anda melakuakn appraove / reject double";
        }
    }
}
