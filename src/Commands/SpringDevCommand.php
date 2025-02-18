<?php

namespace MoonShine\Spring\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SpringDevCommand extends Command
{
    protected $signature = 'spring:dev';

    public function handle(Filesystem $filesystem): int
    {
        $packageStubs = base_path() . '/packages/moonshine/spring/stubs';

        if (! $this->runAnalyse()) {
            return self::FAILURE;
        }

        $filesystem->copyDirectory(app_path('Http/Controllers/Auth'), $packageStubs
            . '/app/Http/Controllers/Auth');
        copy(app_path('Http/Controllers/ProfileController.php'), $packageStubs . '/app/Http/Controllers/ProfileController.php');

        $filesystem->copyDirectory(app_path('Http/Requests/Auth'), $packageStubs
            . '/app/Http/Requests/Auth');
        copy(app_path('Http/Requests/ProfileFormRequest.php'), $packageStubs . '/app/Http/Requests/ProfileFormRequest.php');

        $filesystem->copyDirectory(app_path('View'), $packageStubs . '/app/View');

        copy(base_path('routes/web.php'),  $packageStubs . '/routes/web.php');
        copy(base_path('routes/auth.php'),  $packageStubs . '/routes/auth.php');

        $filesystem->copyDirectory(base_path('tests/Feature/Auth'), $packageStubs
            . '/tests/Feature/Auth');

        $this->components->info('Successfully!');

        return self::SUCCESS;
    }

    private function runAnalyse(): bool
    {
        $process = (new Process(['composer', 'analyse']))
            ->setWorkingDirectory(base_path());

        try {
            $output = $process->mustRun()->getOutput();
            $this->line($output);

            return true;
        } catch (ProcessFailedException $exception) {
            $this->warn($exception->getMessage());

            return false;
        }
    }
}
