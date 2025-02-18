<?php

namespace MoonShine\Spring\Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MoonShine\Spring\Providers\SpringServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected string $appDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('optimize:clear');

        $this->appDir = $this->getApplicationBasePath();

        $this->artisan('moonshine-spring:install');
    }

    protected function setUpTraits(): array
    {
        (new Filesystem())->cleanDirectory(base_path('database/migrations'));

        return parent::setUpTraits();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SpringServiceProvider::class,
        ];
    }
}
