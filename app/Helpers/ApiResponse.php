<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data)
    {
        $message = 'Request successful';
        $code = 200;
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error()
    {
        $message = 'An error occurred';
        $code = 500;
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public static function notFound()
    {
        $message = 'Resource not found';
        return self::error($message, 404);
    }
}
