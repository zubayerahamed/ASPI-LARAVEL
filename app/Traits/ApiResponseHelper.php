<?php

namespace App\Traits;

trait ApiResponseHelper
{
    protected function success($data = null, $message = "Success", $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }

    protected function error($data = null, $message = null, $code)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }
}
