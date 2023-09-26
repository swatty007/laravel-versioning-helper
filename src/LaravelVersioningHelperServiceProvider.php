<?php

namespace Swatty007\LaravelVersioningHelper;

use Illuminate\Support\ServiceProvider;
use Swatty007\LaravelVersioningHelper\Console\Command\VersioningHelper;
use Swatty007\LaravelVersioningHelper\Views\Components\ApplicationName;
use Swatty007\LaravelVersioningHelper\Views\Components\BuildString;
use Swatty007\LaravelVersioningHelper\Views\Components\Copyright;
use Swatty007\LaravelVersioningHelper\Views\Components\Version;

class LaravelVersioningHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-versioning-helper');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-versioning-helper.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-versioning-helper'),
            ], 'views');

            // Registering package commands.
            $this->commands([
                VersioningHelper::class,
            ]);
        }

        $this->loadViewComponentsAs('versioning-helper', [
            ApplicationName::class,
            BuildString::class,
            Copyright::class,
            Version::class,
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-versioning-helper');
    }
}
