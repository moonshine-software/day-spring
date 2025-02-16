## MoonShine Spring

### Install

1. Install the package via Composer:
    ```shell
    composer require moonshine/spring --dev
    ```
2. Run the command:
    ```shell
    php artisan moonshine-spring:install
    ```
3. Add authorization routes to your bootstrap/App:
    ```php
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        //Auth routes
        then: static function (): void {
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        },
    )
    ```
