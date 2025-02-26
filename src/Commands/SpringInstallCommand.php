<?php

namespace MoonShine\Spring\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SpringInstallCommand extends Command
{
    protected $signature = 'moonshine-spring:install';

    public function handle(Filesystem $filesystem): void
    {
        $filesystem->ensureDirectoryExists(app_path('Http/Controllers'));
        $filesystem->copyDirectory(__DIR__ . '/../../stubs/app/Http/Controllers', app_path('Http/Controllers'));

        $filesystem->ensureDirectoryExists(app_path('Http/Requests'));
        $filesystem->copyDirectory(__DIR__ . '/../../stubs/app/Http/Requests', app_path('Http/Requests'));

        $filesystem->ensureDirectoryExists(app_path('View'));
        $filesystem->copyDirectory(__DIR__ . '/../../stubs/app/View', app_path('View'));

        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/routes/auth.php', base_path('routes/auth.php'));

        $filesystem->copyDirectory(__DIR__ . '/../../stubs/tests/Feature', base_path('tests/Feature'));

        $this->mergeFeatures($filesystem);

        $this->components->info('MoonShine Spring installed successfully!');
    }

    private function mergeFeatures(Filesystem $filesystem): void
    {
        if (! config('moonshine-spring.features.sessions')) {
            $filesystem->delete(app_path('Http/Controllers/Auth/SessionController.php'));
            $filesystem->delete(app_path('View/Pages/SessionPage.php'));
        }
    }
}
