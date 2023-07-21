<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\IndexHint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nim = Auth::guard('karyawan')->user()->nim;
        $data['checkAbsen'] = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        return view('presensi.create', $data);
    }
    
    public function jadwal()
    {
        return view ('presensi.jadwal');
    }

    public function history()
    {
        $namabulan = ["", "januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.history');
    }

    public function gethistory(request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nim = Auth::guard('karyawan')->user()->nim;

        $history = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->where('nim', $nim)
            ->orderBy('tgl_presensi')
            ->get();
       // dd($history);
        return view('presensi.gethistory', compact('history'));
    }
    public function lokasi()
    {
        return view ('presensi.lokasi');
    }
    public function prosentase()
    {
        return view ('presensi.prosentase');
    }
    public function terlambat()
    {
        return view ('presensi.terlambat');
    }
    public function store(Request $request)
    {
        $nim = Auth::guard('karyawan')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        
        
        $image = $request->image;
        $folderPath = "public/upload/absensi/";
        // if (File::exists($folderPath)) {
        //     File::makeDirectory($folderPath, $mode = 0777, true, true);
        // }

        $formatName = $nim."-".$tgl_presensi.date("His");;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName. ".png";
        $file = $folderPath . $fileName;
        $data = [
            'nim' => $nim,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'location_in' => $lokasi
        ];
        $simpan = DB::table('presensi')->insert($data);
        Storage::put($file, $image_base64);
        echo json_encode(1);  
    }

    public function update(request $request)
    {
        $nim = Auth::guard('karyawan')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        
        // $latitudekantor = -7.77536279241172;
        // $longitudekantor = 110.37391286621114;
        
        /**
         * trial
         */
        $latitudekantor = -7.2574719;
        $longitudekantor = 112.7520883;

        $lokasi = $request->lokasi;

        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        //dd($radius);
        //dd($lokasi);
        $image = $request->image;
        $folderPath = "public/upload/absensi/";
        // if (File::exists($folderPath)) {
        //     File::makeDirectory($folderPath, $mode = 0777, true, true);
        // }

        $formatName = $nim."-".$tgl_presensi.date("His");;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName. ".png";
        $file = $folderPath . $fileName;

        if($radius > 9){
            echo json_encode([
                'status' => 'false',
                'message' => "Maaf Anda Berada diluar Radius, Jarak Anda ".$radius." Meter dari TEDI"
            ]);
        }else {
            $data = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'location_out' => $lokasi
            ];
            $update = DB::table('presensi')->where('nim',$nim)-> where('tgl_presensi', $tgl_presensi)-> update($data);
            Storage::put($file, $image_base64);
            echo json_encode([
                'status' => 'true',
                'message' => "Anda sudah berhasil absen pulang"
            ]); 
        } 
    }
    //menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

}

//-7.815168,110.3560704


