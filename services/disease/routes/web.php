<?php
use App\Http\Controllers\MaladieController;
use Illuminate\Support\Facades\Route;

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

$router->group(['prefix' => 'maladies'], function () use ($router) {

    $router->get('/', 'MaladieController@index');

    
    // $router->get('/create', 'MaladieController@create'); // <--- Hna fin khassha tkoun
    $router->post('/store', 'MaladieController@store');
    
    $router->get('{id}', 'MaladieController@show');
    $router->put('{id}', 'MaladieController@update');
    $router->delete('{id}', 'MaladieController@destroy');
});


// Route::apiResource('maladies', MaladieController::class);