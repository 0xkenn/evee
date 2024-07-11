<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(SocialController::class)->group(function () {
    Route::get('auth/facebook/redirect', 'facebookRedirect')->where('provider', 'facebook');
    Route::get('auth/{provider}/callback', 'facebookCallback')->where('provider', 'facebook');

    Route::get('auth/{provider}/redirect', 'googleRedirect')->where('provider', 'google');
    Route::get('auth/{provider}/callback', 'googleCallback')->where('provider', 'google');
});


require __DIR__ . '/auth.php';
