<?php

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

// API route group
/*$router->group(['prefix' => 'api'], function () use ($router) {
   // Matches "/api/register
   $router->post('register', 'AuthController@register');

});*/

$router->get('test', 'ExampleController@index');

$router->group(['prefix'     => 'api/auth',], function ($router) {
    $router->post('login', 'AuthController@login');
});

$router->group([
    'middleware' => ['auth:api'],
    'prefix'     => 'api/auth',
], function ($router) {
    $router->patch('update', 'AuthController@update');
    $router->post('register', 'AuthController@register');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');
    $router->post('user/add', 'UserController@userAdd');
    $router->get('usergrouplist', 'UsergroupController@getUserGroupList');
    $router->get('userlist[/{page}]', 'UserController@userList');
    $router->delete('deleteuser/{id}', 'UserController@delete');
    $router->post('addCompany', 'CompanyController@addCompany');

});
