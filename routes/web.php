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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']],function(){
    Route::get('/posts', 'PostController@index');
    Route::post('/post/add', 'PostController@store');
    Route::delete('/post/delete/{post}', 'PostController@destroy');
    Route::post('/post/publish/{id}', 'PostController@publish');
    Route::get('/post/edit/{id}', 'PostController@edit');
    Route::put('/post/update', 'PostController@update');
    Route::get('/categories', 'CategoryController@index');

    Route::get('/offers', 'OfferController@index');
    Route::post('/offer/add', 'OfferController@store');
    Route::delete('/offer/delete/{offer}', 'OfferController@destroy');
    Route::post('/offer/publish/{id}', 'OfferController@publish');
    Route::get('/offer/edit/{id}', 'OfferController@edit');
    Route::put('/offer/update', 'OfferController@update');
    Route::get('/activities', 'ActivityController@index');
});


Route::post('/users/register', 'UserController@register')->middleware('guest');
Route::post('/users/login', 'UserController@login')->middleware('guest');
Route::get('/users/logout', 'UserController@logout')->middleware('auth');
