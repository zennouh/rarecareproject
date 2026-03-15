<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'middleware' => 'jwt'], function () use ($router) {
    $router->get('roles', 'RoleController@index');
    $router->post('roles', 'RoleController@store');
    $router->get('roles/{id}', 'RoleController@show');
    $router->put('roles/{id}', 'RoleController@update');
    $router->delete('roles/{id}', 'RoleController@destroy');
});