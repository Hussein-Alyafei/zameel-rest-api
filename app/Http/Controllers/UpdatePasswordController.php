<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => 'current_password:sanctum',
            'newPassword' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->password = Hash::make($data['newPassword']);
        $user->save();

        return response()->json(['message' => 'ok']);
    }
}
