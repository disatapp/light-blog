<?php
// use BlogController;

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

// Registration Routes...
Route::group(['middleware' => ['web']], function () {
    //routes here
    Route::get('admin/login', 'Disatapp\LightBlog\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('admin/login', 'Disatapp\LightBlog\Http\Controllers\Auth\LoginController@login');
    Route::post('admin/logout', 'Disatapp\LightBlog\Http\Controllers\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('admin/register', 'Disatapp\LightBlog\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('admin/register', 'Disatapp\LightBlog\Http\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('admin/password/reset', 'Disatapp\LightBlog\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('admin/password/email', 'Disatapp\LightBlog\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('admin/password/reset/{token}', 'Disatapp\LightBlog\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('admin/password/reset', 'Disatapp\LightBlog\Http\Controllers\Auth\ResetPasswordController@reset');

    /*
    |--------------------------------------------------------------------------
    | Admin routes
    |--------------------------------------------------------------------------
    */
        Route::get('admin', 'Disatapp\LightBlog\Http\Controllers\DashboardController@reLogin')->name('admin');
    Route::get('admin/dashboard', 'Disatapp\LightBlog\Http\Controllers\DashboardController@index')->name('dashboard');

    //needs to be called before any admin/post/{postId}
    //TODO: CREATE A relationship table and pair it with tags
    //Relationship management
    Route::get('admin/post/{postId}/tag', 'Disatapp\LightBlog\Http\Controllers\DashboardController@tagToPostRead')->name('admin.tagToPostRead');
    Route::post('admin/post/{postId}/tag', 'Disatapp\LightBlog\Http\Controllers\DashboardController@tagToPostStore')->name('admin.tagToPostStore');
    Route::delete('admin/post/{postId}/tag', 'Disatapp\LightBlog\Http\Controllers\DashboardController@tagToPostDelete')->name('admin.tagToPostDelete');

    //Image manage routes
    Route::get('admin/img', 'Disatapp\LightBlog\Http\Controllers\PhotoController@imgManage')->name('admin.imgManage'); 
    Route::post('admin/img', 'Disatapp\LightBlog\Http\Controllers\PhotoController@imgStore')->name('admin.imgStore'); 
    //Change to view and use delete Method 
    Route::get('admin/img/{imgId}/delete', 'Disatapp\LightBlog\Http\Controllers\PhotoController@imgDelete')->name('admin.imgDelete'); 

    //Blog post manage routes
    Route::get('admin/post', 'Disatapp\LightBlog\Http\Controllers\DashboardController@postManage')->name('admin.postManage');
    Route::post('admin/post', 'Disatapp\LightBlog\Http\Controllers\DashboardController@postStore')->name('admin.postStore');
    Route::get('admin/post/{postId}', 'Disatapp\LightBlog\Http\Controllers\DashboardController@showEdit')->name('admin.showEdit');
    Route::post('admin/post/{postId}', 'Disatapp\LightBlog\Http\Controllers\DashboardController@postUpdate')->name('admin.postUpdate'); 
    Route::get('admin/post/{postId}/delete', 'Disatapp\LightBlog\Http\Controllers\DashboardController@postDelete')->name('admin.postDelete'); 

    //Tag manage routes
    Route::get('admin/tag', 'Disatapp\LightBlog\Http\Controllers\TagController@tagManage')->name('admin.tagManage');
    Route::post('admin/tag', 'Disatapp\LightBlog\Http\Controllers\TagController@tagStore')->name('admin.tagStore');
    Route::get('admin/tag/{tagId}', 'Disatapp\LightBlog\Http\Controllers\TagController@tagEdit')->name('admin.tagEdit'); 
    Route::post('admin/tag/{tagId}', 'Disatapp\LightBlog\Http\Controllers\TagController@tagUpdate')->name('admin.tagUpdate'); 
    //Change to view and use delete Method
    Route::get('admin/tag/{tagId}/delete', 'Disatapp\LightBlog\Http\Controllers\TagController@tagDelete')->name('admin.tagDelete'); 
});
