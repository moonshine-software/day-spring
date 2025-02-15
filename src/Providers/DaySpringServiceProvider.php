<?php

declare(strict_types=1);

namespace MoonShine\DaySpring\Providers;

use Illuminate\Support\ServiceProvider;

final class DaySpringServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'day-spring');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'day-spring');
        $this->loadRoutesFrom(__DIR__ . '/../../routes');

        $this->publishes([
            __DIR__ . '/../../config/day-spring.php' => config_path('day-spring.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/day-spring.php',
            'day-spring'
        );

//        $this->publishes([
//            __DIR__ . '/../../public' => public_path('vendor/day-spring'),
//        ], ['day-spring-assets', 'laravel-assets']);
//
//        $this->publishes([
//            __DIR__ . '/../../lang' => $this->app->langPath('vendor/day-spring'),
//        ]);

        $this->commands([]);
    }
}
