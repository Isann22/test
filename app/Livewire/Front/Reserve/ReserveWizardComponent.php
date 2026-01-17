<?php

namespace App\Livewire\Front\Reserve;

use App\Models\City;
use App\Support\ReserveWizardState;
use App\Livewire\Front\Reserve\Step\ChoosePackage;
use App\Livewire\Front\Reserve\Step\PhotoshootDetails;
use App\Livewire\Front\Reserve\Step\Confirmation;
use App\Models\Moment;
use Spatie\LivewireWizard\Components\WizardComponent;

class ReserveWizardComponent extends WizardComponent
{
    public $citySlug = '';
    public $momentSlug = '';

    public function steps(): array
    {
        return [
            ChoosePackage::class,
            PhotoshootDetails::class,
            Confirmation::class,
        ];
    }

    public function mount(string $city, string $moment)
    {
        $this->citySlug = $city;
        $this->momentSlug = $moment;
    }

    public function initialState(): array
    {
        $city = City::select('id', 'name')->where('slug', $this->citySlug)->firstOrFail();
        $moment = Moment::select('id', 'name')->where('slug', $this->momentSlug)->firstOrFail();

        return [
            'choose-package' => [
                'cityId' => $city->id,
                'cityName' => $city->name,
                'momentId' => $moment->id,
                'momentName' => $moment->name,
                'selectedPackageId' => null,
                'price' => 0,
                'hourDuration' => 0,
                'editedPhotos' => 0,
                'downloadablePhotos' => 0,
            ],
        ];
    }

    public function stateClass(): string
    {
        return ReserveWizardState::class;
    }
}
