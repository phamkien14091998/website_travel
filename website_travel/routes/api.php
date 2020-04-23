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
    // Route::post('list-product', 'ProductController@searchProductbyName');
    // Route::post('search-product-portfolio', 'ProductController@searchProductByportfolioByid');
    Route::get('detail-product/{product_id}', 'ProductController@getDetailProduct');
    Route::get('list-portfolio', 'ProductController@getListPortfolio');
    Route::post('new', 'ProductController@create');
    Route::post('delete', 'ProductController@delete');
    Route::post('update', 'ProductController@updateProductById');
});

