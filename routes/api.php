<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function () {


    Route::get('/user/{id}', 'App\Http\Controllers\Api\UserController@index');

    Route::get('/books/get-popular', 'App\Http\Controllers\Api\BookController@get_popular');

    Route::get('/books/get-recommended', 'App\Http\Controllers\Api\BookController@get_recommended');

    Route::get('/books/get-new-release', 'App\Http\Controllers\Api\BookController@get_new_release');

    Route::get('/books/get-members-data', 'App\Http\Controllers\Api\BookController@get_members_data');

    Route::get('/books/get-authors', 'App\Http\Controllers\Api\BookController@get_authors');

    Route::get('/books/dashboard-data', 'App\Http\Controllers\Api\BookController@get_dashboard_data');

    Route::get('/user/get-favorite/{id}', 'App\Http\Controllers\Api\UserController@get_user_favorite_data');

    Route::post('/user/follow-author', 'App\Http\Controllers\Api\UserController@follow_author');

});


Route::post('/auth/login', 'App\Http\Controllers\Api\AuthController@loginUser');

Route::post('/auth/register', 'App\Http\Controllers\Api\AuthController@createUser');

Route::post('/auth/login-with-otp', 'App\Http\Controllers\Api\AuthController@loginWithOtp');    


