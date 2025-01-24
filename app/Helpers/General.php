<?php

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class General
{
    public static function microseconds()
    {
        $mt = explode(' ', microtime());
        return intval($mt[1] * 1E6) + intval(round($mt[0] * 1E6));
    }

    public static function generateId()
    {
        return mt_rand(1000000000, 9999999999) . self::microseconds();
    }

    public static function formatedNumberIDR($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    public static function checkJWT()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            Log::error('No token provided');
            return false;
        }

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            Log::error('Token is invalid or expired');
            return false;
        }

        return true;
    }
}