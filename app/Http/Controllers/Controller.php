<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function success($data, int $code): JsonResponse
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function error($message, int $code): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }
}
