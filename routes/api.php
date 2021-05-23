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

Route::namespace('App\Http\Controllers')->group(function (){

    Route::post('register', 'RegisterController@Register');
    Route::post('login', 'LoginController@Login');


    Route::group( [ 'middleware' => [ 'auth:api', 'scope:admin'] ], function () {

        Route::apiResource('/post', 'PostController');
    });

});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
