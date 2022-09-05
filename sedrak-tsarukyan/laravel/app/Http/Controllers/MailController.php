<?php

namespace App\Http\Controllers;

use App\Mail\SignUpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendEmail($name, $email, $verificationCode){
        $data = [
            'name' => $name,
            'verificationCode' => $verificationCode
        ];
        Mail::to($email)->send(new SignUpMail($data));
    }
}
