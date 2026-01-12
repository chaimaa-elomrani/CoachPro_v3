<?php

use App\Core\Router;

/**
 * Routes configuration
 * 
 * Example routes:
 * $router->get('/', 'HomeController@index');
 * $router->get('/user/{id}', 'UserController@show');
 * $router->post('/user', 'UserController@store');
 */

// Home route
$router->get('/', 'HomeController@index');
