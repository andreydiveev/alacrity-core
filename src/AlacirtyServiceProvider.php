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
    }
}
