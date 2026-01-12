<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Verify;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\ForgotPassword;
use Illuminate\Support\Facades\Route;


Route::get('/', Welcome::class)->name('home');

Route::get('/reserve/{city:slug}', App\Livewire\Front\Reserve\Step\ChoseePackage::class);
// Photographer
Route::prefix('photographer')->name('photographer.')->group(function () {
    Route::view('/', 'components.pages.photographer')->name('index');
    Route::get('/photographer-join', App\Livewire\Front\PhotographerApplicant\Create::class)->name('create');
});


// Destinations (Cities)
Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/', App\Livewire\Front\City\Index::class)->name('index');
    Route::get('/{city:slug}', App\Livewire\Front\City\Show::class)->name('show');
});

// Moments
Route::prefix('moments')->name('moments.')->group(function () {
    Route::get('/', App\Livewire\Front\Moment\Index::class)->name('index');
    Route::get('/{moment:slug}', App\Livewire\Front\Moment\Show::class)->name('show');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::delete('/logout', [Login::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/email/verify', Verify::class)->name('verification.notice');

Route::post('/email/verification-notification', [Verify::class, 'sendVerifyMail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');


Route::get('/auth/google/redirect', [App\Http\Controllers\oauth\GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\oauth\GoogleController::class, 'callback'])->name('auth.google.callback');
Route::get('login/facebook', [App\Http\Controllers\oauth\FacebookController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('login/facebook/callback', [App\Http\Controllers\oauth\FacebookController::class, 'callback']);
