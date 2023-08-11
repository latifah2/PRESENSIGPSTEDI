<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; 

class GoogleAuthController extends Controller
{
    public function authGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            // $dataGoogle = [
            //     'google_id' => $google_user->getId(),
            //     'name' => $google_user->getName(),
            //     'email' => $google_user->getEmail()
            // ];
            // dd($dataGoogle);

            /**
             * cek apakah email telah di daftarkan admin
             */
            $user = User::where('email', $google_user->getEmail())->first();
            if (!$user) {
                return redirect('/')->with(['massage' => 'Akun email anda belum terdaftar oleh admin']);
            }else{
                /**
                 * update google id
                 */
                User::where('email', $google_user->getEmail())->update([
                    'google_id' => $google_user->getId()
                ]);

                /**
                 * login dengan id_karyawan
                 */
                Auth::guard('userAuthentication')->loginUsingId($user->id_karyawan);
                if (Auth::check()) {
                    return redirect('/dashboard');
                }else {
                    return redirect('/')->with(['massage' => 'Gagal Login']);
                }
            }
        }catch (\Throwable $th){
            dd($th);
        }
    }
}
