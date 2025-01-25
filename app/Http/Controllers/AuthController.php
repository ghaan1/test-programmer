<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Format masih ada yang salah'], 400);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $request->session()->start();
                $request->session()->put('user_id', $user->id);
                $request->session()->regenerate();
                $token = JWTAuth::fromUser($user);
                return ApiResponse::success(['token' => $token]);
            } else {
                return response()->json(['error' => 'Email atau password salah'], 401);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error();
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                Log::error('No token provided');
                return ApiResponse::error();
            }

            JWTAuth::authenticate($token);

            JWTAuth::invalidate($token);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();


            return ApiResponse::success(null);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            Log::error('Token error: ' . $e->getMessage());
            return ApiResponse::error();
        } catch (\Exception $e) {
            Log::error('Failed to log out: ' . $e->getMessage());
            return ApiResponse::error();
        }
    }


    public function getUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user);
    }
}