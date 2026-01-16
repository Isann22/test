<?php

namespace App\Support;

use App\Models\City;
use Spatie\LivewireWizard\Support\State;

class ReserveWizardState extends State
{

    public function packageStates(): array
    {
        $choseePackagetepState = $this->forStep('chosee-package');

        return [
            'cityName' => $choseePackagetepState['cityName'],
            'cityId' => $choseePackagetepState['cityId'],
            'momentId' => $choseePackagetepState['momentId'],
            'momentName' => $choseePackagetepState['momentName'],
            'price' => $choseePackagetepState['price'],
        ];
    }
}
