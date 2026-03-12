<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    const GATEWAY_PATHS = [
        "patients" => "http://patients:8000/api/patients",
        "dummyjson" => "https://dummyjson.com",
    ];

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $method = $request->method();
        $path = $request->path();
        $pathParts = explode('/', $path);

        $service = $pathParts[0];
        $pathParameters = array_slice($pathParts, 1);

        if (!array_key_exists($service, self::GATEWAY_PATHS)) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $serviceBase = self::GATEWAY_PATHS[$service];

        $extraPath = implode('/', $pathParameters);
        $serviceUrl = rtrim($serviceBase, '/') . ($extraPath ? '/' . $extraPath : '');

        $queryParams = $request->query();
        $body = $request->all();
        $headers = $request->headers->all();

        $client = new Client();

        try {
            $response = $client->request($method, $serviceUrl, [
                'query' => $queryParams,
                'json' => $body,
                'headers' => $headers
            ]);

            $data = (string) $response->getBody();

            return response()->json(
                json_decode($data, true),
                $response->getStatusCode()
            );

        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $error = (string) $e->getResponse()->getBody();

                return response()->json(
                    json_decode($error, true),
                    $e->getResponse()->getStatusCode()
                );
            }

            return response()->json(['error' => 'Service unavailable'], 503);
        }
    }
}