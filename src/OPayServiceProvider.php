<?php

namespace Triverla\LaravelOpay;

use Illuminate\Support\ServiceProvider;

class OPayServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = false;


    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if (function_exists('config_path') && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/config/opay.php' => config_path('opay.php'),
            ], 'config');
        }
    }


    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/opay.php', 'opay');

        $this->app->bind('laravel-opay', function ($app) {
            $baseUrl = config('opay.base_url');

            return new Opay(
                $baseUrl,
                config('opay')
            );
        });
    }
}
