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

    $dgRoute->group(['prefix' => 'roles'], function () use ($dgRoute) {
        $dgRoute->get('/', 'RoleController@index');
        $dgRoute->post('/', 'RoleController@store');
        $dgRoute->get('/{id}', 'RoleController@show');
    });
});