<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {

	Route::get('/', 'DemoController@index');
	Route::post('/', 'DemoController@index');

	Route::match(['get', 'post'], 'them-ngay', [
		'as' => 'dayPart', 'uses' => 'DemoController@dayPart'
	]);

	Route::match(['get', 'post'], 'chon-lich-trinh', [
		'as' => 'date_parts_join', 'uses' => 'DemoController@chooseRoute'
	]);
	
	Route::get('ket-qua', [
		'as' => 'result', 'uses' => 'DemoController@result'
	]);
	
	Route::get('chi-tiet/{route}/{road}', [
	    'as' => 'review', 'uses' => 'DemoController@review'
	]);
});
