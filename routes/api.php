<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::get('/', 'CategoryController@apiHome');

Route::get('/category/collections/{category}', 'CollectionController@apiCollectionsByCotegory');

Route::get('/collection/{callection}', 'CollectionController@show');

Route::get('/mycollections', 'CollectionController@myCollections');

Route::get('/collection/item/{item}', 'ItemController@show');

Route::delete('/collection/{collection}', 'CollectionController@destroy');

Route::put('/collection', 'CollectionController@updateCollection');
Route::post('/collection', 'CollectionController@store');

Route::post('/comments', 'CommentController@store');
Route::delete('/comments/{comment}', 'CommentController@destroy');
// ----------!!

Route::get('/register/data', 'CategoryController@returnCategoriesDataJSON');
Route::get('/categoryUser/data', 'CategoryController@returnUserCategoryDataJSON');
Route::post('/register/attach', 'CategoryController@attachCategoryUser');
Route::delete('/register/detach', 'CategoryController@detachCategoryUser');

// -----------!!

Route::post('/category', 'CategoryController@store');
Route::put('/category/{id}/update', 'CategoryController@updateCategory');
Route::delete('/category/{id}/destroy', 'CategoryController@deleteCategory');

//------------!!

Route::get('/comments/{comment}', 'CommentController@index');
Route::get('/comments/{comment}/edit', 'CommentController@edit');
Route::put('/comments/{comment}', 'CommentController@update');
//Route::apiResource('comments', 'CommentController');

//------------------------
// ITEM ROUTES
Route::post('/item', 'ItemController@store');
Route::put('/item', 'ItemController@updateItem');
Route::delete('/item/{item}', 'ItemController@destroy');

// LIKES ROUTES

Route::get('/user/lovedCollections/{id}', 'LoveItController@isLovedByUser');
Route::get('/collection/totalLikes/{id}', 'LoveItController@getTotalLikes');
Route::post('/user/{id}/attach', 'LoveItController@attachLoveCollectionUser');
Route::delete('/user/{id}/detach', 'LoveItController@detachLoveCollectionUser');
