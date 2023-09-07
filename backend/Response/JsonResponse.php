<?php
namespace App\Response;

class JsonResponse
{
    public static function make($data, $status)
    {
        header("HTTP/1.1 $status");
        if($status!=200){
            return json_encode(['error' => $data, 'status' => $status]);
        }
        return json_encode($data);
    }
}