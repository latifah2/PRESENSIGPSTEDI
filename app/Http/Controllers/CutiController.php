<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\User;
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
            ->select('cuti.*', 'karyawan.nama_lengkap', 'karyawan.id as id_karyawan')
            ->leftJoin('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            ->orderBy('created_at')
            ->get();
        }
        return view('cuti.cuti', $data);
    }

    public function saveCuti(Request $request)
    {
        $dataUserLogin = Auth::guard('userAuthentication')->user();
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
            // upload file cuti
            $folderPath = "public/upload/cuti/";
            $fileCuti = $request->file('file_cuti');
            $fileCuti->move($folderPath, $filename);

            $simpan = DB::table('cuti')->insert($data);

            /**
             * send email
             */
            $details = [
                'title' => 'Presensi TEDI UGM - Pengajuan Cuti',
                'body' => 'Terdapat pengajauan cuti dari '.$dataUserLogin->nama_lengkap.'. 
                            <br> <br> Segera tidak lanjuti pengajuan cuti melalui link berikut 
                            <br> <a href="tifanias.cloud">tifanias.cloud</a>'
            ];
           
            Mail::to('latifah.k@mail.ugm.ac.id')->send(new SendEmail($details));

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
        
        /**
         * send email to employee
         */
        $getEmailUser = User::where('id_karyawan', $request->id_karyawan)->first();
        $emailKaryawanTujuan = $getEmailUser->email;

        /**
         * send email
         */
        $details = [
            'title' => 'Presensi TEDI UGM - Status Pengajuan Cuti',
            'body' => 'Pengajuan cuti anda telah di '.$request->status.'. 
                        <br><br> Untuk melihat detail pengajuan cuti melalui link berikut 
                        <br><a href="tifanias.cloud">tifanias.cloud</a>'
        ];

        Mail::to($emailKaryawanTujuan)->send(new SendEmail($details));

        if ($update) {
            return redirect('/cuti');
        }else {
            $errorMessage = "Gagal melakukan update status " . $request->status . " cuti, kemungkinan anda melakukan " . $request->status . " double";
            return redirect('/cuti')->with('error', $errorMessage);
        }
    }
}
