<?php

namespace App\Livewire\Front\Reserve\Step;

use Spatie\LivewireWizard\Components\StepComponent;

class Confirmation extends StepComponent
{
    public function stepInfo(): array
    {
        return [
            'label' => 'Confirmation',
        ];
    }

    public function render()
    {
        return view('livewire.front.reserve.step.confirmation', [
            'booking' => $this->state()->bookingDetails(),
        ]);
    }
}
