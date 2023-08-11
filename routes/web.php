<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/user', [UserController::class, 'index']);
route::middleware(['guest:userAuthentication'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class,'proseslogin']);

    Route::get('/auth/google', [GoogleAuthController::class,'authGoogle']);
    Route::get('/auth/google/call-back', [GoogleAuthController::class,'callbackGoogle']);
});

route::middleware(['auth:userAuthentication'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class,'proseslogout']);

    //presensi
    Route::get('/presensi/create',[PresensiController::class,'create']);
    Route::post('/presensi/store',[PresensiController::class,'store']);
    Route::post('/presensi/update',[PresensiController::class,'update']);

    Route::get('/presensi/jadwal',[PresensiController::class,'jadwal']);
    Route::get('/presensi/history',[PresensiController::class,'history']);
    Route::post('/gethistory',[PresensiController::class,'gethistory']);
    Route::get('/presensi/lokasi',[PresensiController::class,'lokasi']);
    Route::get('/presensi/prosentase',[PresensiController::class,'prosentase']);
    Route::get('/presensi/terlambat',[PresensiController::class,'terlambat']);
    Route::post('/getterlambat',[PresensiController::class,'getterlambat']);
    
    //profile
    Route::get('/profile',[ProfileController::class,'profile']);
    Route::get('/profile/edit',[ProfileController::class,'editprofile']);
    Route::post('/{nim}/updateprofile',[ProfileController::class,'updateprofile']);

    //user setting
    Route::get('/user-setting',[UserSettingController::class,'index']);
    Route::post('/user-setting/add',[UserSettingController::class,'add']);

    //cuti
    Route::get('/cuti',[CutiController::class,'cuti']);
    Route::post('/cuti/save',[CutiController::class,'saveCuti']);
    Route::post('/cuti/update-status-cuti',[CutiController::class,'updateStatusCuti']);
    

    
    
});