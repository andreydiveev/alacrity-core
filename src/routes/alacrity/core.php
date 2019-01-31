<?php
/*
|--------------------------------------------------------------------------
| Alacrity\Core Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Alacrity\Core package.
|
*/

Route::group(
    [
        'namespace'  => 'Alacrity\Core\app\Http\Controllers',
        'middleware' => ['web'],
        'prefix'     => config('alacrity.core.route_prefix'),
    ],
    function () {

        // if not otherwise configured, setup the auth routes
        if (config('alacrity.core.setup_auth_routes')) {

            // Authentication Routes...
            Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
            Route::post('login', 'Auth\LoginController@login');
            Route::get('logout', 'Auth\LoginController@logout')->name('logout');
            Route::post('logout', 'Auth\LoginController@logout');

            // Registration Routes...
            Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'Auth\RegisterController@register');

            // Password Reset Routes...
            Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
            Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

            Route::get('home', 'HomeController@index')->name('home');
        }

    });
