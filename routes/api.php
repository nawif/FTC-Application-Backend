<?php

use App\Http\Middleware\CheckAlreadyJoined;
use App\Http\Middleware\CheckAdmin;

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

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('userInfo', 'AuthController@userInfo');

});

Route::group([

    'middleware' => CheckAdmin::class,
    'prefix' => 'admin'

], function () {

    Route::get('/pendingimages', 'UserController@getPendingImages');
    Route::post('/approveimage', 'UserController@approvedImage');


});

Route::group([

    'middleware' => 'api',
    'prefix' => 'user'

], function () {
    //exposed user endpoints
    Route::post('/create', 'UserController@store');

    //protected user endpoints
    Route::group([
        'middleware' => 'jwt.auth',

    ], function () {
        Route::get('/all', 'UserController@getUsers');
        Route::patch('/edit', 'UserController@patch');
        Route::post('/changeprofileimage', 'UserController@changeProfileImage');
    });
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'point'

], function () {
    Route::get('/leaderboard', 'PointController@getLeaderboard');
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'task'

], function () {
    Route::post('/create', 'TaskController@store')->middleware(CheckAlreadyJoined::class);
    Route::get('/user/{id}', 'TaskController@showUserTasks');
});

Route::group([

    'middleware' => 'jwt.auth',
    'prefix' => 'event'

], function () {
    Route::post('/create', 'EventController@store');
    Route::patch('/edit', 'EventController@patchEvent');
    Route::delete('/archive/{id}', 'EventController@archiveEvent');
    Route::get('/all', 'EventController@getEvents');
    Route::get('/{id}', 'EventController@getEventDetails');
    Route::put('/enroll/{id}', 'EventController@enrollInEvent');
});
