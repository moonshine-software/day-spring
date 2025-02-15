<?php

declare(strict_types=1);

namespace MoonShine\Spring\Providers;

use Illuminate\Support\ServiceProvider;

final class SpringServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'spring');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'spring');
        $this->loadRoutesFrom(__DIR__ . '/../../routes');

        $this->publishes([
            __DIR__ . '/../../config/spring.php' => config_path('spring.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/spring.php',
            'spring'
        );

        //        $this->publishes([
        //            __DIR__ . '/../../public' => public_path('vendor/spring'),
        //        ], ['spring-assets', 'laravel-assets']);
        //
        //        $this->publishes([
        //            __DIR__ . '/../../lang' => $this->app->langPath('vendor/spring'),
        //        ]);

        $this->commands([]);
    }
}
