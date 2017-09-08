<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home/{id?}','HomeController@index');
Route::auth();

Route::get('/home/{id?}', 'HomeController@index');
Route::get('/logout', 'HomeController@logout');
Route::get('/addProduct','HomeController@addProduct');
Route::post('/productSubmit','HomeController@productSubmit');
Route::post('/ImageSave','HomeController@SaveImage');
Route::get('/productList','HomeController@productList');
Route::post('/getproduct/{id}','HomeController@getProduct');
Route::post('/formSubmit','HomeController@formEdit');
Route::post('/delproduct/{id}','HomeController@delproduct');
Route::get('/getproductlist','HomeController@getproducts');