<?php

namespace App\Http\Controllers\Traits;


use Illuminate\Http\Response;

trait ResponseTrait
{

    /**
     * @param $response
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseOK($response, $code = null)
    {
        if (is_null($code)) {
            $code = Response::HTTP_OK;
        }

        return response()->json($response, $code);
    }

    /**
     * @return mixed
     */
    protected function responseNoContent()
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

}