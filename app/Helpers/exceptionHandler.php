<?php

namespace App\Helpers;

class ExceptionHandler
{
    public static function handleException($e)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'internal server error!',
            'error' => $e->getMessage(),
        ], 500);
    }
}