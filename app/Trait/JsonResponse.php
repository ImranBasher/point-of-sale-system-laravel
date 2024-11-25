<?php

namespace App\Trait;

trait JsonResponse{
    public function successResponse($data=[], $message = "", $status = true, $code = 200){
        return response()->json([
            'status'    => $status,
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
        ],$code);
    }

    public function errorResponse( $message = "Opps! Something went wrong", $exception = null,  $status = false, $code = 400 ){
        return response()->json([
            'status'    => $status,
            'code'      => $code,
            'message'   => $message,
            'error' => $exception ? $exception->getMessage() : null
//            'error'     => show_Error_In_An_Array($exception)

        ],$code);

    }
}




