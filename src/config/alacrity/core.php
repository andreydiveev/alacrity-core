<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    // The prefix used in all base routes
    // You can make sure all your URLs use this prefix by using the alacrity_url() helper instead of url()
    'route_prefix' => '',

    // Set this to false if you would like to use your own AuthController and PasswordController
    // (you then need to setup your auth routes manually in your routes.php file)
    'setup_auth_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    // Fully qualified namespace of the User model
    'user_model_fqn' => Alacrity\Core\app\Models\AlacrityUser::class,

    // Username column for authentication
    // The Alacrity default is the same as the Laravel default (email)
    // If you need to switch to username, you also need to create that column in your db
    'authentication_column'      => 'email',
    'authentication_column_name' => 'Email',

    // The guard that protects the Alacrity secure routes.
    // If null, the config.auth.defaults.guard value will be used.
    'guard' => 'alacrity',

    // The password reset configuration for Alacrity.
    // If null, the config.auth.defaults.passwords value will be used.
    'passwords' => 'alacrity',

];
