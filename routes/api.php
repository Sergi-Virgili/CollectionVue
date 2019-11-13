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


// ------------



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

Route::get('/', 'AppController@apiHome');

Route::get('/category/collections/{category}', 'AppController@apiCollectionsByCotegory');

Route::get('/collection/{callection}', 'AppController@show');

Route::get('/mycollections', 'CollectionController@myCollections');

Route::get('/collection/item/{item}', 'ItemController@show');

Route::delete('/collection/{collection}', 'AppController@destroy');

Route::put('/collection/{id}', 'CollectionController@update');

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
