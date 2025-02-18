<?php

namespace MoonShine\Spring\Tests\Feature;


use MoonShine\Spring\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class InstallCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function successInstall()
    {
        $this->assertDirectoryExists($this->appDir . '/app/Http/Controllers/Auth');
        $this->assertDirectoryExists($this->appDir . '/app/Http/Requests/Auth');

        $this->assertDirectoryExists($this->appDir . '/app/View/Layouts');
        $this->assertDirectoryExists($this->appDir . '/app/View/Pages');

        $this->assertDirectoryExists($this->appDir . '/tests/Feature/Auth');

        $this->assertFileExists($this->appDir . '/routes/auth.php');
        $this->assertFileExists($this->appDir . '/routes/web.php');
    }
}
