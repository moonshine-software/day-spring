<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(ProfileController::class)->middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', 'index')->name('profile');
    Route::post('/', 'update')->name('profile.update');
});

require __DIR__.'/auth.php';