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


Route::group([
		'prefix' => 'v1',
		'middleware' => 'wants.json',
		'namespace' => 'Api\v1' 
	],
	function () {
		Route::post('/users', 'UserController@store');

		Route::group(['middleware' => 'auth:api'], function () {
			Route::post('/videos', 'VideoController@store');
		});
	
});