<?php

use App\Http\Middleware\CheckAlreadyJoined;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'user'

], function ($router) {
    Route::post('/create', 'UserController@store');
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'point'

], function ($router) {
    Route::post('/create', 'PointController@store');
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'task'

], function ($router) {
    Route::post('/create', 'TaskController@store')->middleware(CheckAlreadyJoined::class);
    Route::get('/user/{id}', 'TaskController@showUserTasks');
});

