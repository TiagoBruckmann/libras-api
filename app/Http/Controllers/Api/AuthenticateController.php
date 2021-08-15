<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

# models
use App\Models\users\User;

class AuthenticateController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'mail' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $mailVerify = User::firstWhere('mail', $request->input('mail'));

        # verify mail or cpf exists
        if ($mailVerify) {
            # status_code 302 = found
            return response()->json([
                'message' => 'mail already exists',
                'status_code' => 302,
            ], 302);
        }

        $data = User::insert([
            'name' => $request->input('name'),
            'mail' => $request->input('mail'),
            'password' => bcrypt($request->password)
        ]);
        
        return response()->noContent();
    }

    public function login(Request $request)
    {
        $request->validate([
            'mail' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'mail' => $request->mail,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'login failed'
            ], 400);
        }

        $user = $request->user();
        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function verify(Request $request)
    {

        if (Auth::guard('api')->check()) {
            return response()->noContent();
        } else {
            return response()->json([
                'message' => 'A request parameter is invalid - token',
                'status_code' => 401
            ],401);
        }

    }
}
