<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

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

$router->post('v1/login', 'v1\AuthController@login');
$router->get('v1/logout', 'v1\HomeController@logout');

/** User Controller Routes */
$router->get('v1/users/', 'v1\UserController@index');
$router->post('v1/users/create', 'v1\UserController@create');
$router->get('v1/users/show/{id}', 'v1\UserController@show');
$router->put('v1/users/update', 'v1\UserController@update');
$router->delete('v1/users/delete/{id}', 'v1\UserController@delete');
