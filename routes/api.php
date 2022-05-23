<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('/users', 'Api\UserController')->names('api.users');
Route::resource('/sections', 'Api\SectionController')->names('api.sections');
Route::post('/upload', 'Api\ImageController@upload')->name('api.upload');


