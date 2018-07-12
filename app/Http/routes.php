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
	
	/*
	 * Required routes for data migration
	 */
	// step 1
	Route::get('/export/shopify/font', 'ShopifyProductController@exportShopifyFont');
	// step 2
	Route::any('/import/shopify/change-imported-data', 'ShopifyProductController@changeImportedData');
	Route::get('/import/shopify/test', 'ShopifyProductController@test');
	// step 3
	Route::any('/import/shopify/save-order-data', 'ShopifyOrderController@saveOrderData');
	// step 4
	Route::any('/import/shopify/import-order-data', 'ShopifyOrderController@importOrderData');
    
	
	/*
	 * List of optional routes
	 */
    // set stock number of all products to 50
    Route::get('stock','StockController@setMassStock');
    // add all text color option to all monogramming product
    Route::get('color','StockController@addColorOption');
        
});
