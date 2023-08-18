<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index(){

        $details = [
            'title' => 'Mail from tifanisa.cloud',
            'body' => 'This is for testing email using smtp'
        ];
       
        Mail::to('aldipraddana@gmail.com')->send(new SendEmail($details));
       
        dd("Email sudah terkirim.");
    
    }
}
