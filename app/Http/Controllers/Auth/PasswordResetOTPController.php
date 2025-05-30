<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SendEmailException;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetOTPController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
            ],
            ['email' => 'البريد الالكتروني غير صحيح']
        );

        $email = $request->email;

        $otp = rand(100000, 999999);
        DB::table('password_reset_otps')->upsert([
            'email' => $email,
            'otp' => Hash::make($otp),
            'created_at' => Carbon::now(),
        ], 'email');

        try {
            Mail::to($email)->send(new PasswordResetMail($otp));

            return response()->json(['message' => 'Email sent.'], 200);
        } catch (Exception $e) {
            throw new SendEmailException('Failed To Send Email.', 502);
        }

        throw new SendEmailException('Password reset failed', 502);
    }
}
