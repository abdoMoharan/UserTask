<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $verificationCode = mt_rand(100000, 999999);
        $data['verification_code'] = $verificationCode;
        $user = User::create($data);
        return response()->json(['user' => $user, 'access_token' => $user->createToken('auth_token')->plainTextToken]);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('phone_number', $data['phone_number'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            if ($user->verified) {
                $accessToken = $user->createToken('auth_token')->plainTextToken;
                return response()->json(['user' => $user, 'access_token' => $accessToken]);
            } else {
                return response()->json(['error' => 'Unauthorized - Account not verified'], 401);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function verifyCode(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->verifyCode($request->verification_code)) {
            return response()->json(['message' => 'Code verified successfully']);
        }

        return response()->json(['error' => 'Invalid verification code'], 422);
    }
}
