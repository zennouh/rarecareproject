<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GatewayController extends Controller
{

    const GATEWAY_PATHS = [
        "patients" => "http://patients:8000/api/patients",
        "disease" => "http://disease:8008/maladies",
        "treatment" => "http://treatment:8007/api/treatments",
        "authentication" => "http://authentication:8001/",
        "medical-record" => "http://medical-record:8002/api/medical-records"
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
        // dd($serviceUrl);

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
            return response()->json([
                'error' => 'Service connection failed',
                'message' => $e->getMessage()
            ], 502);
        }
    }
}
