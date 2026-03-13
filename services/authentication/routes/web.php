<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/test', function () {
    return response()->json(['ok' => true]);
});


$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');


$router->group(['middleware' => 'jwt.auth'], function () use ($router) {

    $router->get('/me', 'AuthController@me');
    $router->get('/user/report/pdf', 'AuthController@generatePdf');
});
