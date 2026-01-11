<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Verify;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\ForgotPassword;
use Illuminate\Support\Facades\Route;


Route::get('/', Welcome::class)->name('home');


Route::view('/photographer', 'components.pages.photographer')->name('photographer');
Route::get('/destinations', App\Livewire\Front\City\Index::class)->name('destinations.index');
Route::get('/destination/{city:slug}', App\Livewire\Front\City\Show::class)->name('destination.show');

Route::get('/moments', App\Livewire\Front\Moment\Index::class)->name('moments.index');

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
