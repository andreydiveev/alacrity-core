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

        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'alacrity');

        $this->addCustomAuthConfigurationValues();
        $this->setupRoutes($this->app->router);
        $this->publishFiles();
    }

    public function addCustomAuthConfigurationValues()
    {

        // add the alacrity_users authentication provider to the configuration
        app()->config['auth.providers'] = app()->config['auth.providers'] +
            [
                'alacrity' => [
                    'driver'  => 'eloquent',
                    'model'   => config('alacrity.core.user_model_fqn'),
                ],
            ];
        // add the alacrity_users password broker to the configuration
        app()->config['auth.passwords'] = app()->config['auth.passwords'] +
            [
                'alacrity' => [
                    'provider'  => 'alacrity',
                    'table'     => 'password_resets',
                    'expire'    => 60,
                ],
            ];
        // add the alacrity_users guard to the configuration
        app()->config['auth.guards'] = app()->config['auth.guards'] +
            [
                'alacrity' => [
                    'driver'   => 'passport',
                    'provider' => 'alacrity',
                ],
            ];
    }

    public function publishFiles()
    {
        $alacrity_config_files = [__DIR__.'/config' => config_path()];

        // establish the minimum amount of files that need to be published, for Alacrity to work
        $minimum = array_merge(
            $alacrity_config_files
        );

        $this->publishes($alacrity_config_files, 'config');
        $this->publishes($minimum, 'minimum');

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
}
