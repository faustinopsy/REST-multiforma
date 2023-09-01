<?php
namespace App\Response;

class JsonResponse
{
    public static function make($data, $status)
    {
        header("HTTP/1.1 $status");
        return json_encode($data);
    }
}