<?php

declare(strict_types=1);

namespace App\Helpers\Trait;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

use function response;

trait ApiResponseHelpers
{
    private ?array $_api_helpers_defaultSuccessData = [];

    /**
     * @param string|\Exception $message
     * @param  string|null  $key
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound(
        string $message = '',
        ?string $key = 'error'
    ): JsonResponse {
        return $this->apiResponse(
            $message,
            [$key => $this->morphMessage($message)],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param array|Arrayable|JsonSerializable|null $contents
     */
    public function respondWithSuccess($message, $contents = []): JsonResponse
    {
        $contents = $this->morphToArray($contents) ?? [];

        $data = [] === $contents
            ? $this->_api_helpers_defaultSuccessData
            : $contents;

        return $this->apiResponse($message, $data);
    }


    /**
     * Respond with Content Only
     *
     * @param array|Arrayable|JsonSerializable|null $contents
     */
    public function respondWithContentOnly($contents = [], $code = 200): JsonResponse
    {
        return response()->json($contents, $code);
    }

    public function setDefaultSuccessResponse(?array $content = null): self
    {
        $this->_api_helpers_defaultSuccessData = $content ?? [];
        return $this;
    }

    public function respondOk(string $message, $data = null): JsonResponse
    {
        return $this->respondWithSuccess($message, $data);
    }

    public function respondUnAuthenticated(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            $message,
            ['error' => $message ?? 'Unauthenticated'],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function respondForbidden(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            $message,
            ['error' => $message ?? 'Forbidden'],
            Response::HTTP_FORBIDDEN
        );
    }

    public function respondError(?string $message = null): JsonResponse
    {
        return $this->apiResponse(
            $message,
            ['error' => $message ?? 'Error'],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * Created API Response
     *
     * @param mixed $data
     */
    public function respondCreated($message = '', $data = null): JsonResponse
    {
        $data ??= [];
        return $this->apiResponse(
            $message,
            $this->morphToArray($data),
            Response::HTTP_CREATED
        );
    }

    /**
     * Updated API Response
     *
     * @param mixed $data
     */
    public function respondUpdated($message = '', $data = null): JsonResponse
    {
        $data ??= [];
        return $this->apiResponse(
            $message,
            $this->morphToArray($data),
            Response::HTTP_OK
        );
    }

    /**
     * @param string|\Exception $message
     * @param  string|null  $key
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondFailedValidation(
        $message,
        ?string $key = 'message'
    ): JsonResponse {
        return $this->apiResponse(
            $message,
            [$key => $this->morphMessage($message)],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function respondTeapot(): JsonResponse
    {
        return $this->apiResponse(
            '',
            ['message' => 'I\'m a teapot'],
            Response::HTTP_I_AM_A_TEAPOT
        );
    }

    /**
     * @param array|Arrayable|JsonSerializable|null $data
     */
    public function respondNoContent(string $message = '', $data = null): JsonResponse
    {
        $data ??= [];
        $data = $this->morphToArray($data);

        return $this->apiResponse($message, $data, Response::HTTP_NO_CONTENT);
    }

    private function apiResponse(string $message = '', $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 'success'
        ], $code);
    }

    /**
     * @param array|Arrayable|JsonSerializable|null $data
     * @return array|null
     */
    private function morphToArray($data)
    {
        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        return $data;
    }

    /**
     * @param string|\Exception $message
     * @return string
     */
    private function morphMessage($message): string
    {
        return $message instanceof Exception
            ? $message->getMessage()
            : $message;
    }
}
