<?php

namespace App\Providers;

use App\Livewire\Front\Reserve\ReserveWizardComponent;
use App\Livewire\Front\Reserve\Step\ChoseePackage;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Livewire::component('reserve-wizard', ReserveWizardComponent::class);
        Livewire::component('chosee-package', ChoseePackage::class);
    }
}
