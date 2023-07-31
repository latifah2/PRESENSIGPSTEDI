<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\IndexHint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    protected $latitude, $longitude;

    // $latitudekantor = -7.77536279241172;
    // $longitudekantor = 110.37391286621114;
    public function __construct()
    {
        $this->latitude = -7.2574719;
        $this->longitude = 112.7520883;
    }
    
    public function create()
    {
        $hariini = date("Y-m-d");
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $data['checkAbsen'] = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        return view('presensi.create', $data);
    }
    
    public function jadwal()
    {
        return view ('presensi.jadwal');
    }

    public function history()
    {
        $data['namabulan'] = ["", "januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.history', $data);
    }

    public function gethistory(request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $idKaryawan = Auth::guard('userAuthentication')->user()->id;

        if (Auth::guard('userAuthentication')->user()->user_status == 'Guest') {
            $history = DB::table('presensi')
            ->select('presensi.*', 'karyawan.nama_lengkap')
            ->leftJoin('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->where('presensi.id_karyawan', $idKaryawan)
            ->orderBy('tgl_presensi')
            ->get();
        }else{
            /**
             * data khusus admin
             */
            $history = DB::table('presensi')
            ->select('presensi.*', 'karyawan.nama_lengkap')
            ->leftJoin('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();
        }

        return view('presensi.gethistory', compact('history'));
    }
    public function lokasi()
    {
        return view ('presensi.lokasi');
    }

    private function getLastDateOfMonth($year, $month) {
        // Check if the month is within valid range (1 to 12)
        if ($month < 1 || $month > 12) {
            return "Invalid month";
        }
    
        // Get the last date of the specified month and year
        $lastDate = date("Y-m-t", mktime(0, 0, 0, $month, 1, $year));
    
        return $lastDate;
    }

    public function prosentase()
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $id =  Auth::guard('userAuthentication')->user()->id;
        $fromDate = date('Y-m')."-01";
        $toDate = $this->getLastDateOfMonth(date('Y'), date('m'));
        //$data['listjamin'] = DB::table('presensi')->where('nim',$nim )->get();
        if (Auth::guard('userAuthentication')->user()->user_status == 'Guest') {
            $tepatwaktu = DB::table('presensi')->whereBetween('jam_in', [
                $fromDate ." 01:00:00", 
                $toDate ." 07:00:00"
            ])
            ->where('id_karyawan', $id)
            ->get();
            $terlambat = DB::table('presensi')->whereBetween('jam_in', [
                $fromDate ." 07:00:00", 
                $toDate ." 15:00:00"
            ])
            ->where('id_karyawan', $id)
            ->get();
            $cuti = DB::table('cuti')->whereBetween('tanggal_izin', ['2023-07-01', '2023-07-30'])
            ->where('id_karyawan', $id)
            ->get();
        } else {
            $tepatwaktu = DB::table('presensi')->whereBetween('jam_in', [
                $fromDate ." 01:00:00", 
                $toDate ." 07:00:00"
            ])
            ->get();
            $terlambat = DB::table('presensi')->whereBetween('jam_in', [
                $fromDate ." 07:00:00", 
                $toDate ." 15:00:00"
            ])
            ->get();
            $cuti = DB::table('cuti')->whereBetween('tanggal_izin', ['2023-07-01', '2023-07-30'])
            ->get();
        }
        
        // Menghitung jumlah data untuk masing-masing label
        $tepatWaktuCount = count($tepatwaktu);
        $terlambatCount = count($terlambat);
        $cutiCount = count($cuti);

        // Menggabungkan data ke dalam array asosiatif
        $dataChart = [
        'tepatWaktu' => $tepatWaktuCount,
        'terlambat' => $terlambatCount,
        'cuti' => $cutiCount
        ];
        return view ('presensi.prosentase', compact ('tepatwaktu', 'cuti', 'terlambat', 'dataChart'));
    }
    
    public function terlambat()
    {
        $namabulan = ["", "januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Dapatkan daftar karyawan untuk bagian admin
        $listKaryawan = [];
        if (Auth::guard('userAuthentication')->user()->user_status != 'Guest') {
            $listKaryawan = DB::table('karyawan')->select('id', 'nama_lengkap')->get();
        }
        return view ('presensi.terlambat', compact('namabulan', 'listKaryawan'));
    }

    public function getterlambat(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $iKaryawan = $request->karyawan;
        $idKaryawan = Auth::guard('userAuthentication')->user()->id;

        if (Auth::guard('userAuthentication')->user()->user_status == 'Guest') {
            $terlambat = DB::table('presensi')
            ->select('presensi.*', 'karyawan.nama_lengkap')
            ->leftJoin('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->whereRaw('TIME(jam_in) > "07:00:00"')
            ->where('presensi.id_karyawan', $idKaryawan)
            ->orderBy('tgl_presensi')
            ->get();
            
        }else{
            /**
             * data khusus admin
             */
            $terlambat = DB::table('presensi')
            ->select('presensi.*', 'karyawan.nama_lengkap')
            ->leftJoin('karyawan', 'presensi.id_karyawan', '=', 'karyawan.id')
            ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
            ->whereRaw('TIME(jam_in) > "07:00:00"')
            ->when($iKaryawan, function ($query, $iKaryawan) {
                return $query->where('presensi.id_karyawan', $iKaryawan);
            })
            ->orderBy('tgl_presensi')
            ->get();
        }    
        return view('presensi.getterlambat', compact('terlambat'));
    }
    public function store(Request $request)
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        
        $latitudekantor = $this->latitude;
        $longitudekantor = $this->longitude;

        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        if($radius > 9){
            echo json_encode([
                'status' => 'false',
                'message' => "Maaf Anda Berada diluar Radius, Jarak Anda ".$radius." Meter dari TEDI"
            ]);
        }else{
            $image = $request->image;
            $folderPath = "public/upload/absensi/";
    
            $formatName = $nim."-".$tgl_presensi.date("His");
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
            echo json_encode([
                'status' => 'true',
                'message' => "Anda sudah berhasil absen masuk"
            ]); 
        }  
    }

    public function update(request $request)
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;

        $latitudekantor = $this->latitude;
        $longitudekantor = $this->longitude;

        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $image = $request->image;
        $folderPath = "public/upload/absensi/";

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
            $update = DB::table('presensi')->where('nim',$nim)->where('tgl_presensi', $tgl_presensi)->update($data);
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

    public function profile()
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $karyawan = DB::table('karyawan')->where('nim',$nim)->first();
        return view('presensi.profile', compact('karyawan'));
    }

    public function editprofile()
    {
        return view('presensi.editprofile');
    }

    public function updateprofile(Request $request)
    {
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
    
        if(!empty($request->password)) {
            $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
         //   'password' => Hash::make($password)
            ];
        } else {
            $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
            'password' => $password
        ];
        } 

        $update = DB::table('karyawan')->where('nim', $nim)->update($data);
        if ($update){
            return Redirect::back()->with(['success' => 'Data Berhasil di Update']);
        }else {
            return Redirect::back()->with(['error' => 'Data Gagal di Update']);
        }
    }

}

//-7.815168,110.3560704


