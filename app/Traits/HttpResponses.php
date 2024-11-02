<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
trait HttpResponses
{
    public function response(string $message, string|int $status, array|Model|Collection $data = [])
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status,
            'data' => $data
        ], $status);
    }
    public function error(string $message, string|int $status, array $errors, array $data = [])
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
