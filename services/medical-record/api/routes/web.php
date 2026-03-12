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
$router->get('/me', function () use ($router) {
    return 'hhhhh';
});

$router->group(['prefix'=>'api/medical-records'],function() use($router){
    $router->get('/','MedicalRecordController@index');
    $router->get('/{id}','MedicalRecordController@show');
    $router->post('/create','MedicalRecordController@create');
    $router->put('/update/{id}','MedicalRecordController@update');
    $router->delete('/delete/{id}','MedicalRecordController@destroy');
    $router->get('/{id}/generatePdf','MedicalRecordController@generatePdf');
});
