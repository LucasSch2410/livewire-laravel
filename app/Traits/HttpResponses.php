<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    /**
     * Prepare a success response.
     *
     * @param string $message The response message.
     * @param string|int $status The HTTP status code.
     * @param array|Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $data Optional data to include in the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(string $message, string|int $status, array|Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $data = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status,
            'data' => $data
        ], $status);
    }

    /**
     * Prepare an error response.
     *
     * @param string $message The error message.
     * @param string|int $status The HTTP status code.
     * @param array $errors Optional array of specific errors.
     * @param array|\Illuminate\Support\Collection $data Optional data to include in the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(string $message, string|int $status, array $errors = [], array|\Illuminate\Support\Collection $data = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'status' => $status,
            'errors' => $errors,
            'data' => $data
        ], $status);
    }
}
