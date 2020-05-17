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

Route::get('auth/google/url', 'SocialController@googleLoginUrl');
Route::get('auth/google/callback', 'SocialController@googleLoginCallback');
// Route::group(['middleware' => ['web']], function () {
//     Route::get('auth','SocialController@redirectToProvider');
//     Route::get('auth/callback','SocialController@handleProviderCallback');
    
// });

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
    Route::get('11provinces', 'PlaceController@getList11Provinces');
    Route::post('search-place-by-province-id', 'PlaceController@searchPlaceByProvivnceId');
    Route::get('search-place-by-province-id/{province_id}', 'PlaceController@searchPlaceByProvivnceIdGET');
    Route::get('detail/{famous_place_id}', 'PlaceController@getDetailPlace');
    Route::post('new', 'PlaceController@createPlace');
    Route::post('update/{famous_place_id}', 'PlaceController@updatePlaceById');
    Route::delete('delete/{famous_place_id}', 'PlaceController@deletePlace');
    Route::get('list-home', 'PlaceController@getList8Provinces');
     //lấy địa điểm theo id
    Route::post('get-famous-id', 'PlaceController@getPlaceByid'); 
    // lấy ra chi tiết địa điểm ở trang chủ
    Route::get('detail-home/{famous_place_id}', 'PlaceController@getDetail');


});

 
// router quản lý bài viết
Route::group(['prefix'=>'post'],function(){
    Route::get('all', 'PostController@getAllPostDuyet'); // get all post đã duyệt
    Route::get('list', 'PostController@getListPost');  // get list post chưa duyệt theo user
    Route::get('list-approved', 'PostController@getListPost9Duyet'); // get list 9 post đã duyệt
    Route::get('detail/{post_id}', 'PostController@getDetailPost');
    Route::post('new', 'PostController@create');
    Route::post('search-post', 'PostController@getPostByFlag');
    Route::post('update/{post_id}', 'PostController@updatePostById');
    Route::delete('delete/{post_id}', 'PostController@delete');
    Route::get('list-not-approved', 'PostController@getAllPostChuaDuyet');
    // admin phê duyệt hoạc hủy bài viết của user
    Route::post('approved-or-notapproved', 'PostController@approvedOrNotApprovedPost');
    Route::get('place/detail/{famous_place_id}', 'PostController@getAllPostByPlaceId');
    Route::get('province/detail/{province_id}', 'PostController@getAllPostByProvinceId');
});

// router quản lý user (thông tin, collection, tạo lịch trình) 
Route::group(['prefix'=>'member'],function(){
    Route::get('username/{user_name}', 'UserController@getUserByUserName'); // get user by user name
    Route::get('userid/{user_id}', 'UserController@getUserByUserId'); // get user by user id
    Route::post('update/{user_id}', 'UserController@updateUserById');
});

// router quản lý collection
Route::group(['prefix'=>'collection'],function(){
    Route::post('list', 'CollectionController@getListCollectionByUser');  // get list collection theo user
    Route::get('detail/{collection_id}', 'CollectionController@getDetailCollection'); // laáy ra các địa điểm trong bộ sưu tập
    Route::post('new', 'CollectionController@create');
    Route::post('update/{colletion_id}', 'CollectionController@updateCollectionById');
    // Route::delete('delete/{collection_id}', 'CollectionController@delete');
    Route::delete('delete/{collection_id}', 'CollectionController@deleteCollection');
    Route::get('detail-id/{collection_id}', 'CollectionController@getDetailCollectionById');
    Route::post('add-place', 'CollectionController@addPlaceIntoCollection');  // thêm địa điểm vào bộ sưu tập của user
    Route::delete('delete-place/{famous_place_id}', 'CollectionController@deletePlaceCollection'); // xóa địa điểm khỏi bộ sưu tập
    
});

// router quản lý schedule
Route::group(['prefix'=>'schedule'],function(){
    Route::get('list-vehicle', 'ScheduleController@getListVehicle');  // get list vehicle
    Route::post('new', 'ScheduleController@create');
    Route::post('list', 'ScheduleController@getListScheduleByUser');  // get list schdule theo user
    Route::get('detail/{trip_id}', 'ScheduleController@getDetailSchedule'); // get detail chi tiết chuyến đi phía trong
    Route::post('update/{trip_id}', 'ScheduleController@updateScheduleById');
    Route::delete('delete/{trip_id}', 'ScheduleController@deleteSchedule');
    Route::get('detail-trip/{trip_id}', 'ScheduleController@getDetailTrips'); // get ra chi tiết bảng trip
    Route::delete('delete-detail/{trip_detail_id}', 'ScheduleController@deleteScheduleDetail'); // xóa chedule-detail
    Route::get('trip-detail/{trip_detail_id}', 'ScheduleController@getDetailScheduleDetail'); // get ra chi tiết bảng trip-detail
    Route::post('update-trip-detail/{trip_detail_id}', 'ScheduleController@updateScheduleDetail'); // cập nhật bảng trip_detail
    
});

Route::group(['middleware' => ['web']], function () {
    Route::get('cart/add/{product_id}', 'CartController@addToCart');
    Route::get('cart/get-all/', 'CartController@getAllProductForCart');
    Route::get('cart/delete/{product_id}', 'CartController@deleteProductFromCart');
    Route::get('cart/total-money', 'CartController@getTotalCart');
    
});
// router comments  
Route::group(['prefix'=>'comment'],function(){
    Route::get('list-post/{post_id}', 'CommentController@getAllCommentByPostId');  // get all comment của bài post
    Route::post('new-post', 'CommentController@createCommentByPostId'); // thêm comment của bài post 
    Route::delete('delete/{comment_id}', 'CommentController@deleteComment');
});

