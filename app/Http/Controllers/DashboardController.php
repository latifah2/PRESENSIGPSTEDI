<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        //$hariini = date("Y-m-d");
        //$nim = Auth::guard('karyawan')->user()->nim;
        //$data['infoAbsen'] = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        //return view('dashboard.dashboard', $data);
        $hariini = date("Y-m-d");
        $bulanini = date("m");
        $tahunini = date("Y");
        $nim = Auth::guard('karyawan')->user()->nim;
        $data['infoAbsen'] = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        $presensihariini = DB::table('presensi')->where('nim', $nim)->where('tgl_presensi', $hariini)->first();
        $historybulanini = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderBy('tgl_presensi', 'desc')
        ->get();
        return view ('dashboard.dashboard', $data, compact('presensihariini', 'historybulanini'));
    }
}

