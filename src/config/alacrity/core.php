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
    | Registration Open
    |--------------------------------------------------------------------------
    |
    | Choose whether new users are allowed to register.
    | This will show up the Register button in the menu and allow access to the
    | Register functions in AuthController.
    |
    | By default the registration is open only on localhost.
    */
    'registration_open' => env('ALACRITY_REGISTRATION_OPEN', env('APP_ENV') === 'local'),

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    // Fully qualified namespace of the User model
    'user_model_fqn' => Alacrity\Core\App\Models\AlacrityUser::class,


    // Can be a single class or an array of clases
    'middleware_class' => [
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Alacrity\Core\App\Http\Middleware\UseBackpackAuthGuardInsteadOfDefaultAuthGuard::class,
    ],
    // Alias for that middleware
    'middleware_key' => 'core',
    // Note: It's recommended to use the backpack_middleware() helper everywhere, which pulls this key for you.


    // Username column for authentication
    // The Alacrity default is the same as the Laravel default (email)
    // If you need to switch to username, you also need to create that column in your db
    'authentication_column'      => 'email',
    'authentication_column_name' => 'Email',

    // The guard that protects the Alacrity secure routes.
    // If null, the config.auth.defaults.guard value will be used.
    'guard' => 'alacrity-web',

    // The password reset configuration for Alacrity.
    // If null, the config.auth.defaults.passwords value will be used.
    'passwords' => 'alacrity-passwords-broker',

    /*
    |--------------------------------------------------------------------------
    | Passport
    |--------------------------------------------------------------------------
    */

    'passport_setup_routes' => true,
    'passport_enable_implicit_grants' => true,

    // in seconds, unlimited if null
    // NOTE: Personl Access Tokens will be unlimited anyway
    'passport_token_ttl' => null,
    'passport_refresh_token_expires_in_days' => null,

];
