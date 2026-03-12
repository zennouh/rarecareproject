<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/test', function () {
    return response()->json(['ok' => true]);
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

/*
|--------------------------------------------------------------------------
| Protected routes
|--------------------------------------------------------------------------
*/

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {

    $router->get('/me', 'AuthController@me');

});
