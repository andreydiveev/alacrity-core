<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 28.01.19
 * Time: 17:30
 */

namespace Alacrity\Core;


use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('core', function () {
            return new Core;
        });
    }

    public function boot()
    {
//        $this->addCustomAuthConfigurationValues();
//        $this->publishFiles();
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
                    'driver'   => 'session',
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
}
