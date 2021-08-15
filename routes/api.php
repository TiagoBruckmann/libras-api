<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api', 'as' => 'api.'], function() {

    Route::group(['prefix' => 'system', 'middleware' => ['guest']], function() {
        Route::get('test', 'HealthCheckController@HealthCheck');
    });
    
    # routes guest
    Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function() {
        Route::post('register', 'AuthenticateController@register');
        Route::post('login', 'AuthenticateController@login');
    });

    # routes authenticate
    Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function() {
            
        # users
        Route::post('update-level', 'UsersController@updateLevel');
        Route::get('verify', 'AuthenticateController@verify');
        Route::get('get-user', 'UsersController@getUser');

    });
});
