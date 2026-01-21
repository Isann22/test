<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Verify;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\ForgotPassword;
use Illuminate\Support\Facades\Route;


Route::get('/', Welcome::class)->name('home');

Route::get('/reserve/{city:slug}/{moment:slug}', App\Livewire\Front\Reserve\ReserveWizardComponent::class)
    ->middleware(['auth', 'verified'])
    ->name('reserve');

// Photographer
Route::prefix('photographer')->name('photographer.')->group(function () {
    Route::view('/', 'pages.photographer')->name('index');
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

Route::get('/email/verify', Verify::class)->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', [Verify::class, 'sendVerifyMail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');


// User Settings
Route::get('/settings', App\Livewire\Setting\Profile::class)
    ->middleware(['auth', 'verified'])
    ->name('settings');

// My Reservations
Route::prefix('my-reservations')->name('reserved.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', App\Livewire\Reserved\Index::class)->name('index');
    Route::get('/{reservation}', App\Livewire\Reserved\Show::class)->name('show');
});

// Photographer Dashboard
Route::middleware(['auth', 'role:photographer'])->prefix('photographer-dashboard')->name('photographer.')->group(function () {
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', App\Livewire\Photographer\ListReservations::class)->name('index');
    });
});



Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', App\Livewire\Admin\AdminDashboard::class)->name('admin.dashboard');

    // Cities
    Route::prefix('cities')->group(function () {
        Route::get('/', App\Livewire\Admin\Cities\ListCities::class)->name('cities.list');
        Route::get('/create', App\Livewire\Admin\Cities\CreateCity::class)->name('cities.create');
        Route::get('/{city:slug}/edit', App\Livewire\Admin\Cities\EditCity::class)->name('city.update');
    });

    // Moments
    Route::prefix('moments')->group(function () {
        Route::get('/', App\Livewire\Admin\moments\ListMoments::class)->name('moments.list');
        Route::get('/create', App\Livewire\Admin\moments\CreateMoment::class)->name('moments.create');
        Route::get('/{moment:slug}/edit', App\Livewire\Admin\moments\EditMoment::class)->name('moment.update');
    });

    // Photographer Applicants
    Route::prefix('photographer-applicants')->group(function () {
        Route::get('/', App\Livewire\Admin\PhotographerApplicants\ListPhotographerApplicants::class)->name('photographer-applicants-list');
        Route::get('/{photographer}', App\Livewire\Admin\PhotographerApplicants\ShowPhotographerApplicant::class)->name('photographers-applicant-view');
    });

    // Reservations
    Route::prefix('reservations')->name('admin.reservations.')->group(function () {
        Route::get('/', App\Livewire\Admin\Reservations\ListReservations::class)->name('index');
        Route::get('/{reservation}', App\Livewire\Admin\Reservations\ShowReservation::class)->name('show');
    });

    // Packages
    Route::prefix('packages')->name('admin.packages.')->group(function () {
        Route::get('/', App\Livewire\Admin\Packages\ListPackages::class)->name('index');
        Route::get('/create', App\Livewire\Admin\Packages\CreatePackage::class)->name('create');
        Route::get('/{package}/edit', App\Livewire\Admin\Packages\EditPackage::class)->name('edit');
    });

    // Photographers
    Route::prefix('photographers')->name('admin.photographers.')->group(function () {
        Route::get('/', App\Livewire\Admin\Photographers\ListPhotographers::class)->name('index');
        Route::get('/{photographer}', App\Livewire\Admin\Photographers\ShowPhotographer::class)->name('show');
    });
});

Route::get('/auth/google/redirect', [App\Http\Controllers\oauth\GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\oauth\GoogleController::class, 'callback'])->name('auth.google.callback');
Route::get('login/facebook', [App\Http\Controllers\oauth\FacebookController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('login/facebook/callback', [App\Http\Controllers\oauth\FacebookController::class, 'callback']);
