<?php
if (!function_exists('jsonFormat')) {
    function jsonFormat($data = [], $message = 'Success', $status = 200)
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];
        if(!empty($data)){
            $response['data']= $data;
        }
        return response()->json($response, $status);
    }
}
