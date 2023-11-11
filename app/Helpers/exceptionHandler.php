<?php

namespace App\Helpers;

class ExceptionHandler
{
    public static function handleException($e)
    {
        return response()->json([
            'status' => false,
            'message' => 'login failed!',
            'error' => "internal server error!",
            //'error' => $e->getMessage(),
        ], 500);
    }
}
