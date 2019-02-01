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
        'namespace'  => 'Alacrity\Core\App\Http\Controllers',
        'middleware' => ['web'],
        'prefix'     => config('alacrity.core.route_prefix'),
    ],
    function () {

        // if not otherwise configured, setup the auth routes
        if (config('alacrity.core.setup_auth_routes')) {

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */
            Route::get('logout', 'Auth\LoginController@logout')->name('logout');
            Route::post('logout', 'Auth\LoginController@logout');

            Route::group(['middleware' => ['guest:'.alacrity_guard_name()]], function () {
                Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
                Route::post('login', 'Auth\LoginController@login');
            });

            /*
            |--------------------------------------------------------------------------
            | Registration
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => ['guest:'.alacrity_guard_name()]], function () {
                Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
                Route::post('register', 'Auth\RegisterController@register');
            });

            /*
            |--------------------------------------------------------------------------
            | Password Reset
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => ['guest:'.alacrity_guard_name()]], function () {
                Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
                Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
                Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
            });

            /*
            |--------------------------------------------------------------------------
            | Under authorization
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => ['auth:'.alacrity_guard_name()]], function () {

                /*
                |--------------------------------------------------------------------------
                | Email verification
                |--------------------------------------------------------------------------
                */
                Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
                Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
                Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

                Route::get('home', 'HomeController@index')->name('home')->middleware('verified');
            });

        }

    });

Route::group(
    [
        'namespace'  => 'Alacrity\Core\App\Http\Controllers',
        'middleware' => ['api'],
        'prefix'     => config('alacrity.core.route_prefix'),
    ],
    function () {


    });
