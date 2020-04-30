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
    // router trang quản lý sản phẩm
    Route::get('list-product', 'ProductController@index');
    Route::post('search-product', 'ProductController@searchProductbyNameOrPortfolioId');
    // Route::post('search-product-portfolio', 'ProductController@searchProductByportfolioByid');
    Route::get('detail-product/{product_id}', 'ProductController@getDetailProduct');
    Route::get('list-portfolio', 'ProductController@getListPortfolio');
    Route::post('new', 'ProductController@create');
    Route::delete('delete/{product_id}', 'ProductController@delete');
    Route::post('update/{product_id}', 'ProductController@updateProductById');

    // router trang ban sản phẩm
    Route::get('list-product-new', 'ProductController@getProductNew');
    // router xem sản phẩm theo id thể loại
    Route::get('search-by-portfolio_id/{portfolio_id}', 'ProductController@searchByPortfolio_id');

});

// router quản lý địa điểm
Route::group(['prefix'=>'place'],function(){
    Route::get('list', 'PlaceController@getListPlace');
    Route::get('province', 'PlaceController@getListProvince');
    Route::post('search-place-by-province-id', 'PlaceController@searchPlaceByProvivnceId');
    Route::get('detail/{famous_place_id}', 'PlaceController@getDetailPlace');
    Route::post('new', 'PlaceController@createPlace');
    Route::post('update/{famous_place_id}', 'PlaceController@updatePlaceById');
    Route::delete('delete/{famous_place_id}', 'PlaceController@deletePlace');

});

// router quản lý bài viết
Route::group(['prefix'=>'post'],function(){
    Route::get('list', 'PostController@getListPost');
    Route::get('detail/{post_id}', 'PostController@getDetailPost');
    Route::post('new', 'PostController@create');
    Route::post('search-post', 'PostController@getPostByFlag');
    
    // Route::post('update/{famous_place_id}', 'PlaceController@updatePlaceById');
    // Route::delete('delete/{famous_place_id}', 'PlaceController@deletePlace');


});


