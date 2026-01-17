<?php

namespace App\Support;

use Spatie\LivewireWizard\Support\State;

class ReserveWizardState extends State
{

    public function packageStates(): array
    {
        $choseePackagetepState = $this->forStep('choose-package');

        return [
            'cityName' => $choseePackagetepState['cityName'],
            'cityId' => $choseePackagetepState['cityId'],
            'momentId' => $choseePackagetepState['momentId'],
            'momentName' => $choseePackagetepState['momentName'],
            'price' => $choseePackagetepState['price'],
        ];
    }
}
