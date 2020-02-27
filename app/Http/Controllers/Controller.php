<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function createResponseFromData($httpCode, $data)
    {
        $response = response()->json([
            'status' => strval($httpCode),
            'data' => $data,
        ], $httpCode, [], JSON_PRETTY_PRINT);

        return $response;
    }
}
