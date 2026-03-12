<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('api/docs', function() {
    $path = storage_path('api-docs/api-docs.json');
    if (file_exists($path)) {
        return response()->json(json_decode(file_get_contents($path)));
    }
    return response()->json(['error' => 'Documentation not found'], 404);
});

$router->get('api/documentation', function() {
    $path = base_path('resources/views/swagger.html');
    return response(file_get_contents($path), 200)->header('Content-Type', 'text/html');
});

$router->get('api/treatments', 'TreatmentController@index');
$router->post('api/treatments', 'TreatmentController@store');
$router->get('api/treatments/{id}', 'TreatmentController@show');
$router->put('api/treatments/{id}', 'TreatmentController@update');
$router->delete('api/treatments/{id}', 'TreatmentController@destroy');
