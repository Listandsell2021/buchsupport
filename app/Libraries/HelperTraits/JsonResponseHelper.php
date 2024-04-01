<?php


namespace App\Libraries\HelperTraits;


use Illuminate\Http\JsonResponse;

trait JsonResponseHelper
{

    /**
     * Return Json Response
     *
     * @param $status
     * @param string $message
     * @param mixed $data
     * @param int $headerStatus
     * @return JsonResponse
     */
	public function apiJsonResponse($status, string $message = '', mixed $data = [], int $headerStatus = 200): JsonResponse
    {
        return response()->json([
            'status' => (bool) $status ? 'success' : 'error',
            'message' => $message,
            'data' => $data
        ], $headerStatus);
	}


    /**
     * Return Json Response
     *
     * @param int $status
     * @param string $message
     * @param mixed $data
     * @param int $headerStatus
     * @return JsonResponse
     */
    public function apiSimpleJsonResponse($data = [], string $message = '', int $status = 1, int $headerStatus = 200): JsonResponse
    {
        return response()->json([
            'status' => (bool) $status ? 'success' : 'error',
            'message' => $message,
            'data' => $data
        ], $headerStatus);
    }



}
