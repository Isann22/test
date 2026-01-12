<?php

namespace App\Livewire\Front\Reserve\Step;

use App\Models\City;
use Livewire\Attributes\Layout;
use Spatie\LivewireWizard\Components\StepComponent;

#[Layout('components.layouts.app')]
class ChoseePackage extends StepComponent
{
    public City $city;

    public function mount(City $city)
    {
        $this->city = $city;
    }

    public function submit()
    {

        $this->nextStep();
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Chose Package',
        ];
    }

    public function render()
    {
        return view('livewire.front.reserve.step.chosee-package');
    }
}
