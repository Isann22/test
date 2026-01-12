<?php

namespace App\Livewire\Front\Reserve;

use App\Livewire\Front\Reserve\Step\ChoseePackage;
use App\Support\ReserverWizardState;
use Spatie\LivewireWizard\Components\WizardComponent;

class ReserveWizardComponent extends WizardComponent
{
    public function steps(): array
    {
        return [
            ChoseePackage::class
        ];
    }

    public function stateClass(): string
    {
        return ReserverWizardState::class;
    }
}
