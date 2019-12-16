<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/', 'HomeController@index')->name('home');
Route::get('/', function () {
    return redirect(route('login'));
});

Route::group(['middleware' => ['auth'] ], function () {
    //Route::get('/users{any}', 'ViewController@viewUsers')->where('any', '.*');
    //Route::get('/users', 'ViewController@viewUsers')->name('users.view');
    //Route::get('/sections/{any}', 'ViewController@viewSections')->where('any', '.*')/*->name('sections.view')*/;
    //Route::get('/sections{any}', 'ViewController@viewSections')->where('any', '.*');
    Route::resource('/users', 'UserViewController')->names('users');
    Route::resource('/sections', 'SectionViewController')->names('sections');
});

Auth::routes();


