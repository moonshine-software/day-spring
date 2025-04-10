<?php

declare(strict_types=1);

namespace MoonShine\Spring\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Spring\Commands\SpringDevCommand;
use MoonShine\Spring\Commands\SpringInstallCommand;

final class SpringServiceProvider extends ServiceProvider
{
    /**
     * @var array<int, string>
     */
    protected array $commands = [
        SpringInstallCommand::class,
        SpringDevCommand::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'spring');

        $this->publishes([
            __DIR__ . '/../../config/spring.php' => config_path('spring.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/spring.php',
            'spring'
        );

        $this->commands([]);
    }
}
