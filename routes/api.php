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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('registeration', 'API\UserController@registeration');


Route::group(['middleware' => 'auth:api'], function(){

	Route::get('logout', 'API\UserController@logout');
    Route::post('updateprofile', 'API\UserController@updateprofile');
    Route::get('book-list', 'API\BookController@index');
    Route::post('create-book', 'API\BookController@store');
    Route::post('get-single-book/{id}', 'API\BookController@show');
    Route::post('updatebook/{id}', 'API\BookController@update');
    Route::post('deletebook/{id}', 'API\BookController@update');
	//Route::post('/lessoncontentedit/{id}', 'API\CourseController@lessoncontentedit'); 
	//Route::get('/lessoncontentdelete/{id}', 'API\CourseController@lessoncontentdelete'); 

});