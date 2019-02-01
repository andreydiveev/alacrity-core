<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 28.01.19
 * Time: 17:30
 */

namespace Alacrity\Core;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Route;

class CoreServiceProvider extends ServiceProvider
{
    const VERSION = '1.0.0';

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/alacrity/core.php';

    public function register()
    {
        $this->app->bind('core', function () {
            return new Core;
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $_SERVER['ALACRITY_CORE_VERSION'] = $this::VERSION;

        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(__DIR__.'/config/alacrity/core.php', 'alacrity.core');
        $this->mergeConfigFrom(__DIR__.'/config/passport.php', 'passport');

        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'alacrity');
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'alacrity');

        $this->addCustomAuthConfigurationValues();
        $this->registerMiddlewareGroup($this->app->router);
        $this->setupRoutes($this->app->router);
        $this->setupPassport();
    }

    public function registerMiddlewareGroup(Router $router)
    {
        $middleware_key = config('alacrity.core.middleware_key');
        $middleware_class = config('alacrity.core.middleware_class');

        if (!is_array($middleware_class)) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);

            return;
        }

        foreach ($middleware_class as $item) {
            $router->pushMiddlewareToGroup($middleware_key, $item);
        }
    }

    public function addCustomAuthConfigurationValues()
    {

        // add the alacrity_users authentication provider to the configuration
        app()->config['auth.providers'] = app()->config['auth.providers'] +
            [
                'alacrity-users' => [
                    'driver'  => 'eloquent',
                    'model'   => config('alacrity.core.user_model_fqn'),
                ],
            ];
        // add the alacrity_users password broker to the configuration
        app()->config['auth.passwords'] = app()->config['auth.passwords'] +
            [
                'alacrity-passwords-broker' => [
                    'provider'  => 'alacrity-users',
                    'table'     => 'password_resets',
                    'expire'    => 60,
                ],
            ];
        // add the alacrity_users guard to the configuration
        app()->config['auth.guards'] = app()->config['auth.guards'] +
            [
                'alacrity-passport' => [
                    'driver' => 'passport',
                    'provider' => 'alacrity-users',
                ],
            ];
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/alacrity, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    public function setupPassport()
    {
        // setup Passport routes if enabled
        if (config('alacrity.core.passport_setup_routes')) {
            Passport::routes();
        }

        // enable implicit grants
        if (config('alacrity.core.passport_enable_implicit_grants')) {
            Passport::enableImplicitGrant();
        }

        // Passport::tokensExpireIn(Carbon::now()->addSeconds(config('alacrity.core.passport_token_ttl')));
        // Passport::refreshTokensExpireIn(Carbon::now()->addSeconds(config('alacrity.core.passport_refresh_token_ttl')));

    }
}
