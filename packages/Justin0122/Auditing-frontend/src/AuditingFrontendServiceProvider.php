<?php

namespace Justin0122\AuditingFrontend;

use Illuminate\Support\ServiceProvider;

class AuditingFrontendServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'justin0122');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'justin0122');
        $this->loadViewComponentsAs('justin0122', [
            'audit-trail' => \Justin0122\AuditingFrontend\AuditingFrontend::class,
        ]);
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/auditing-frontend.php', 'auditing-frontend');

        // Register the service the package provides.
        $this->app->singleton('auditing-frontend', function ($app) {
            return new AuditingFrontend;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auditing-frontend'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/auditing-frontend.php' => config_path('auditing-frontend.php'),
        ], 'auditing-frontend.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/justin0122'),
        ], 'auditing-frontend.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/justin0122'),
        ], 'auditing-frontend.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/justin0122'),
        ], 'auditing-frontend.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
