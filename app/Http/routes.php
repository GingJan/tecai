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
    $dgRoute->post('/login', 'AdminController@login');

    $dgRoute->group(['middleware' => 'jwt.auth'], function () use ($dgRoute) {
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

            $dgRoute->match(['put', 'patch'], '/{id}', 'RoleController@update');
            $dgRoute->delete('/{id}', 'RoleController@destroy');
//        $dgRoute->put('/{id}', 'RoleController@update');
//        $dgRoute->patch('/{id}', 'RoleController@update');
        });
    });
});