<?php

namespace App\Helpers;

class ExceptionHandler
{
    public static function handleException($e)
    {
        return response()->json([
            'status' => false,
            'message' => 'internal server error!',
            'error' => 'internal server error!',
            // 'error' => $e->getMessage()
        ], 500);
    }
}
