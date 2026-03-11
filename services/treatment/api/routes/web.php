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
    return response()->json(json_decode(file_get_contents(storage_path('api-docs/api-docs.json'))));
});

$router->get('/treatments', 'TreatmentController@index');
$router->post('/treatments', 'TreatmentController@store');
$router->get('/treatments/{id}', 'TreatmentController@show');
$router->put('/treatments/{id}', 'TreatmentController@update');
$router->delete('/treatments/{id}', 'TreatmentController@destroy');
