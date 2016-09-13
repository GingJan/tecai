<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

DingoRoute::group(['namespace' => 'System'], function($dgRoute) {
    $dgRoute->post('/admins', 'AdminController@store');
    $dgRoute->post('/login', 'AccountController@login');

    $dgRoute->group(['middleware' => 'jwt_check'], function () use ($dgRoute) {
        $dgRoute->group(['prefix' => 'roles'], function () use ($dgRoute) {
            $dgRoute->get('/', 'RoleController@index');
            $dgRoute->get('/{id}', 'RoleController@show');
            $dgRoute->post('/', 'RoleController@store');
            $dgRoute->match(['put', 'patch'], '/{id}', 'RoleController@update');
            $dgRoute->delete('/{id}', 'RoleController@destroy');
        });

        $dgRoute->group(['prefix' => 'admins'], function () use ($dgRoute) {
            $dgRoute->get('/', 'AdminController@index');
            $dgRoute->get('/{id}', 'AdminController@show');
            $dgRoute->match(['put', 'patch'], '/{id}', 'AdminController@update');
            $dgRoute->delete('/{id}', 'AdminController@destroy');
//        $dgRoute->put('/{id}', 'AdminController@update');
//        $dgRoute->patch('/{id}', 'AdminController@update');
        });
    });
});

DingoRoute::group(['namespace' => 'User'], function($dgRoute) {
    $dgRoute->post('/users', 'UserController@store');

    $dgRoute->group(['middleware' => 'jwt_check'], function () use ($dgRoute) {
        $dgRoute->group(['prefix' => 'users'], function () use ($dgRoute) {
            $dgRoute->get('/', 'UserController@index');
            $dgRoute->get('/{account}', 'UserController@show');
            $dgRoute->match(['put', 'patch'], '/{account}', 'UserController@update');
            $dgRoute->delete('/{account}', 'UserController@destroy');
        });
    });
});