<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GatewayController extends Controller
{
  
    const GATEWAY_PATHS = [
        "patients" => "http://patients:8000/api/patients",
        "dummyjson" => "https://dummyjson.com",
    ];

    public function index(Request $request)
    {
        $path = $request->path();
        $pathParts = explode('/', $path);

        $service = $pathParts[0] ?? '';
        $pathParameters = array_slice($pathParts, 1);

        if (!array_key_exists($service, self::GATEWAY_PATHS)) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $serviceBase = self::GATEWAY_PATHS[$service];
        $extraPath = implode('/', $pathParameters);
        $serviceUrl = rtrim($serviceBase, '/') . ($extraPath ? '/' . $extraPath : '');
        $headers = $request->headers->all();
        unset($headers['host']);

        $client = new Client(['timeout' => 10]); 

        try {
            $options = [
                'query'   => $request->query(),
                'headers' => $headers,
                'http_errors' => false, 
            ];

           
            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
                $options['json'] = $request->all();
            }

            $response = $client->request($request->method(), $serviceUrl, $options);

            $data = json_decode((string) $response->getBody(), true);
            // dd((string) $response->getBody());
            return response()->json(
                $data,
                $response->getStatusCode()
            );
        } catch (\Exception $e) {
            Log::error("Gateway Error: " . $e->getMessage());
            return response()->json(['error' => 'Service connection failed'], 502);
        }
    }
}
