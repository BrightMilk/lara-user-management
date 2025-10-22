<?php

namespace App\Domain\Shared\DTO;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

readonly class ApiResponseData
{
    public function __construct(
        public bool    $success,
        public string  $message,
        public mixed   $data = null,
        public ?array  $errors = null,
        public ?string $locale = null,
        public ?string $timestamp = null
    ) {}

    public static function success(
        string $messageKey,
        mixed $data = null,
        int $statusCode = 200
    ): JsonResponse {
        $includeTimestamp = config('api.response.include_timestamp', false);

        $response = [
            'success' => true,
            'message' => __($messageKey),
            'data' => $data,
        ];

        if ($includeTimestamp) {
            $response['timestamp'] = Carbon::now()->toISOString();
        }

        return response()->json($response, $statusCode);
    }

    public static function error(
        string $messageKey,
        ?array $errors = null,
        int $statusCode = 400
    ): JsonResponse {
        $includeTimestamp = config('api.response.include_timestamp', false);

        $response = [
            'success' => false,
            'message' => __($messageKey),
            'errors' => $errors,
        ];

        if ($includeTimestamp) {
            $response['timestamp'] = Carbon::now()->toISOString();
        }

        return response()->json($response, $statusCode);
    }
}
