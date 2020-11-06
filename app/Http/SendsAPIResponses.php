<?php


namespace App\Http;


use Symfony\Component\HttpFoundation\Response;

trait SendsAPIResponses
{
    public function sendSuccessAPIResponse($data, $statusCode = Response::HTTP_OK)
    {
        return \response()->json([
                                     'error' => false,
                                     'data' => $data
                                 ], $statusCode);
    }

    public function sendErrorAPIResponse($errorMsg, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return \response()->json([
                                     'error' => true,
                                     'errorMsg' => $errorMsg
                                 ], $statusCode);
    }
}
