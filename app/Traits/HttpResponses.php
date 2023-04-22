<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data,$message=null,$code=200)
    {
        return response()->json([
            'status' => 'Response was successful',
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($data,$message=null,$code)
    {
        return response()->json([
            'status' => 'Error has failed',
            'message' => $message,
            'data' => $data,
        ],$code);
    }
}