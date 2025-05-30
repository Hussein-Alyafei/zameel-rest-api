<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'otp' => 'required',
                'email' => 'required|email|exists:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'email' => 'البريد الإلكتروني غير صحيح',
                'password' => 'كلمة المرور يجب ان تتكون من 8 حروف وتحتوي على حرف كبير وحرف صغير ورقم ورمز على الاقل',
            ]
        );

        $user = User::where('email', $request->email)->first();
        $record = DB::table('password_reset_otps')
            ->where('created_at', '>', Carbon::now()->subMinutes(config('auth.passwords.users.expire')))
            ->where('email', $request->email)->firstOrFail(['*'], 'No reset requests.');

        if (Hash::check($request->otp, $record->otp)) {
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();

            event(new PasswordReset($user));
            User::where('email', $request->email)->first()->tokens()->delete();

            return response()->json(['message' => 'Password reset.'], 200);
        } else {
            return response()->json(['message' => 'Bad request.'], 400);
        }

        throw new Exception('Password reset failed', 500);
    }
}
