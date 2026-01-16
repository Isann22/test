<?php

namespace App\Livewire\Front\Reserve\Step;

use Spatie\LivewireWizard\Components\StepComponent;

class PhotoshootDetails extends StepComponent
{

    public function stepInfo(): array
    {
        return [
            'label' => 'photoshoot details',
        ];
    }
    public function render()
    {
        return view('livewire.front.reserve.step.photoshoot-details', [
            'package' => $this->state()->packageStates(),
        ]);
    }
}
