<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class EnveService
{
    public static function response(array $devResp, array $prodRes, string $mode, int $statusCode): JsonResponse
    {
        $response = match (strtolower($mode)) {
            'dev' => $devResp,
            'prod' => $prodRes,
            default => ['message' => 'Invalid environment configuration']
        };

        return new JsonResponse($response, $statusCode);
    }
}
