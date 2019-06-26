<?php
// use BlogController;

Route::get('/t/t',function(){return 'Hello World';});

/*
|--------------------------------------------------------------------------
| Blog routes
|--------------------------------------------------------------------------
*/

Route::get('{locale}/blog', 'Pavinbd\LightBlog\Http\Controllers\BlogController@getBlog')->name('blog');
Route::get('{locale}/blog/{slug}', 'Pavinbd\LightBlog\Http\Controllers\BlogController@showBlog')->name('blog.post');
Route::get('{locale}/blog/tag/{slug}', 'Pavinbd\LightBlog\Http\Controllers\BlogController@getBlogByTags')->name('blog.tag');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

// Registration Routes...
Route::group(['middleware' => ['web']], function () {
    //routes here
    Route::get('admin/login', 'Pavinbd\LightBlog\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('admin/login', 'Pavinbd\LightBlog\Http\Controllers\Auth\LoginController@login');
    Route::post('admin/logout', 'Pavinbd\LightBlog\Http\Controllers\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('admin/register', 'Pavinbd\LightBlog\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('admin/register', 'Pavinbd\LightBlog\Http\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('admin/password/reset', 'Pavinbd\LightBlog\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('admin/password/email', 'Pavinbd\LightBlog\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('admin/password/reset/{token}', 'Pavinbd\LightBlog\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('admin/password/reset', 'Pavinbd\LightBlog\Http\Controllers\Auth\ResetPasswordController@reset');

    /*
    |--------------------------------------------------------------------------
    | Admin routes
    |--------------------------------------------------------------------------
    */
        Route::get('admin', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@reLogin')->name('admin');
    Route::get('admin/dashboard', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@index')->name('dashboard');

    //needs to be called before any admin/post/{postId}
    //TODO: CREATE A relationship table and pair it with tags
    //Relationship management
    Route::get('admin/post/{postId}/tag', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@tagToPostRead')->name('admin.tagToPostRead');
    Route::post('admin/post/{postId}/tag', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@tagToPostStore')->name('admin.tagToPostStore');
    Route::delete('admin/post/{postId}/tag', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@tagToPostDelete')->name('admin.tagToPostDelete');

    //Image manage routes
    Route::get('admin/img', 'Pavinbd\LightBlog\Http\Controllers\PhotoController@imgManage')->name('admin.imgManage'); 
    Route::post('admin/img', 'Pavinbd\LightBlog\Http\Controllers\PhotoController@imgStore')->name('admin.imgStore'); 
    //Change to view and use delete Method 
    Route::get('admin/img/{imgId}/delete', 'Pavinbd\LightBlog\Http\Controllers\PhotoController@imgDelete')->name('admin.imgDelete'); 

    //Blog post manage routes
    Route::get('admin/post', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@postManage')->name('admin.postManage');
    Route::post('admin/post', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@postStore')->name('admin.postStore');
    Route::get('admin/post/{postId}', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@showEdit')->name('admin.showEdit');
    Route::post('admin/post/{postId}', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@postUpdate')->name('admin.postUpdate'); 
    Route::get('admin/post/{postId}/delete', 'Pavinbd\LightBlog\Http\Controllers\DashboardController@postDelete')->name('admin.postDelete'); 

    //Tag manage routes
    Route::get('admin/tag', 'Pavinbd\LightBlog\Http\Controllers\TagController@tagManage')->name('admin.tagManage');
    Route::post('admin/tag', 'Pavinbd\LightBlog\Http\Controllers\TagController@tagStore')->name('admin.tagStore');
    Route::get('admin/tag/{tagId}', 'Pavinbd\LightBlog\Http\Controllers\TagController@tagEdit')->name('admin.tagEdit'); 
    Route::post('admin/tag/{tagId}', 'Pavinbd\LightBlog\Http\Controllers\TagController@tagUpdate')->name('admin.tagUpdate'); 
    //Change to view and use delete Method
    Route::get('admin/tag/{tagId}/delete', 'Pavinbd\LightBlog\Http\Controllers\TagController@tagDelete')->name('admin.tagDelete'); 
});
