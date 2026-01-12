<?php

namespace App\Livewire\Front\Reserve;

use App\Models\City;
use App\Support\ReserveWizardState;
use App\Livewire\Front\Reserve\Step\ChoseePackage;
use App\Livewire\Front\Reserve\Step\PhotoshootDetails;
use Spatie\LivewireWizard\Components\WizardComponent;

class ReserveWizardComponent extends WizardComponent
{
    public $slug = '';

    public function steps(): array
    {
        return [
            PhotoshootDetails::class,
            ChoseePackage::class,

        ];
    }

    public function mount(string $city)
    {
        $this->slug = $city;
    }

    public function initialState(): array
    {
        $city = City::where('slug', $this->slug)->firstOrFail();
        return [
            'chosee-package' => [
                'cityName' => $city->name,
                'price' => $city->price,
            ],
        ];
    }

    // public function stateClass(): string
    // {
    //     return ReserveWizardState::class;
    // }
}
