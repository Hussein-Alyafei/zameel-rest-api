<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            $token = $user->createToken($data['deviceName'], $user->abilities());

            return ['token' => $token->plainTextToken];
        } else {
            return response()->json(['massage' => 'wrong password or email'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'logged out'], 200);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        return response()->json(['data' => $user->toArray()]);
    }
}
