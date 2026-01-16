<?php

namespace App\Livewire\Front\Reserve;

use App\Models\City;
use App\Support\ReserveWizardState;
use App\Livewire\Front\Reserve\Step\ChoseePackage;
use App\Livewire\Front\Reserve\Step\PhotoshootDetails;
use App\Models\Moment;
use Spatie\LivewireWizard\Components\WizardComponent;

class ReserveWizardComponent extends WizardComponent
{
    public $citySlug = '';
    public $momentSlug = '';


    public function steps(): array
    {
        return [
            ChoseePackage::class,
            PhotoshootDetails::class,
        ];
    }

    public function mount(string $city, string $moment)
    {
        $this->citySlug = $city;
        $this->momentSlug = $moment;
    }

    public function initialState(): array
    {

        $city = City::where('slug', $this->citySlug)->firstOrFail();
        $moment = Moment::select('id', 'name')->where('slug', $this->momentSlug)->firstOrFail();

        return [
            'chosee-package' => [
                'cityId' => $city->id,
                'cityName' => $city->name,
                'momentId' => $moment->id,
                'momentName' => $moment->name,
                'price' => $city->price,
            ],
        ];
    }

    public function stateClass(): string
    {
        return ReserveWizardState::class;
    }
}
