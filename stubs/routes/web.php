<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use MoonShine\Spring\Http\Middleware\ProfileMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(ProfileController::class)->middleware(['auth', ProfileMiddleware::class])->prefix('profile')->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'update')->name('profile.update');
    Route::post('/update-password', 'updatePassword')->name('profile.password.update');
});

require __DIR__.'/auth.php';
