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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix'=>'user'],function(){
//     Route::post('/login','UserController@login')->name("user.login");
// });

Route::post('register','UserController@register');
Route::post('login','UserController@login');
Route::get('profile','UserController@getAuthenticatedUser');

Route::middleware('auth:api')->get('/users',function(Request $request){
    return $request->user();
});

 /*api product group*/
 Route::group(['prefix'=>'product'],function(){
    Route::get('list-product', 'ProductController@index');
    Route::get('list-portfolio', 'ProductController@getListPortfolio');
    Route::post('new', 'ProductController@create');
    Route::post('', 'ProductController@delete');
    Route::post('', 'ProductController@getCustomerGroupById');
});

