<?php
namespace App\Response;

class JsonResponse
{
    public static function make($data, $status)
    {
        header("HTTP/1.1 $status");
        if($status!=200 || $status!=201){
            echo json_encode(['error' => $data, 'status' => $status]);
        }
        echo json_encode($data);
    }
}