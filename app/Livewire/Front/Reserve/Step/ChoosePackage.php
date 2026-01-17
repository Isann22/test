<?php

namespace App\Livewire\Front\Reserve\Step;

use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Locked;
use Illuminate\Validation\ValidationException;
use Spatie\LivewireWizard\Components\StepComponent;

class ChoosePackage extends StepComponent
{
    #[Locked]
    public $cityId = '';

    #[Locked]
    public $cityName = '';

    #[Locked]
    public $momentId = '';

    #[Locked]
    public $momentName = '';

    #[Locked]
    public $price = 0;


    protected function rules()
    {
        return [
            'cityId'   => ['required', 'string', 'exists:cities,id'],
            'momentId' => ['required', 'string', 'exists:moments,id'],
            'cityName'   => ['required', 'string'],
            'momentName' => ['required', 'string'],
            'price'      => ['required', 'numeric', 'min:0'],
        ];
    }

    public function submit()
    {
        try {
            $this->validate();
            $this->nextStep();
        } catch (ValidationException $e) {
            Toaster::error("System error occurred. Please refresh the page and try again.");

            return;
        }
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
