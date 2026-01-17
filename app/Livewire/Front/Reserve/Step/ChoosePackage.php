<?php

namespace App\Livewire\Front\Reserve\Step;

use Spatie\LivewireWizard\Components\StepComponent;

class ChoosePackage extends StepComponent
{
    public $cityId = '';
    public $cityName = '';
    public $momentId = '';
    public $momentName = '';
    public $price = 0;

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
        return view('livewire.front.reserve.step.choose-package');
    }
}
