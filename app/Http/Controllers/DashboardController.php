<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m");
        $tahunini = date("Y");
        $nim = Auth::guard('userAuthentication')->user()->nim;
        $data['infoAbsen'] = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        $data['presensihariini'] = DB::table('presensi')->where('nim', $nim)->where('tgl_presensi', $hariini)->first();
        $data['historybulanini'] = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderBy('tgl_presensi', 'desc')
        ->get();
        $data['userInfo'] = Auth::guard('userAuthentication')->user();
        return view ('dashboard.dashboard', $data);
    }
}

