<?php

namespace App\Support;

use Spatie\LivewireWizard\Support\State;

class ReserveWizardState extends State
{

    public function packageStates(): array
    {
        $choosePackageStepState = $this->forStep('choose-package');

        return [
            'cityName' => $choosePackageStepState['cityName'],
            'cityId' => $choosePackageStepState['cityId'],
            'momentId' => $choosePackageStepState['momentId'],
            'momentName' => $choosePackageStepState['momentName'],
            'price' => $choosePackageStepState['price'],
            'selectedPackageId' => $choosePackageStepState['selectedPackageId'] ?? null,
            'hourDuration' => $choosePackageStepState['hourDuration'] ?? 0,
        ];
    }

    public function bookingDetails(): array
    {
        $packageState = $this->forStep('choose-package');
        $detailsState = $this->forStep('photoshoot-details');

        $subtotal = (float) ($packageState['price'] ?? 0);
        $taxRate = 0.12; // 12% tax
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        return [
            // Package info
            'cityName' => $packageState['cityName'] ?? '',
            'momentName' => $packageState['momentName'] ?? '',
            'price' => $subtotal,
            'hourDuration' => $packageState['hourDuration'] ?? 0,
            'editedPhotos' => $packageState['editedPhotos'] ?? 0,
            'downloadablePhotos' => $packageState['downloadablePhotos'] ?? 0,
            
            // Details from photoshoot-details step
            'date' => $detailsState['date'] ?? null,
            'time' => $detailsState['time'] ?? null,
            'pax' => $detailsState['pax'] ?? 1,
            'location' => $detailsState['location'] ?? '',
            'locationDetails' => $detailsState['locationDetails'] ?? '',
            'additionalInfo' => $detailsState['additionalInfo'] ?? '',

            // Payment calculation
            'subtotal' => $subtotal,
            'taxRate' => $taxRate,
            'tax' => $tax,
            'total' => $total,
        ];
    }
}
