<?php

namespace App\Livewire\Front\Reserve\Step;

use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Validation\ValidationException;
use Spatie\LivewireWizard\Components\StepComponent;

class PhotoshootDetails extends StepComponent
{
    #[Validate('required|date|after:today')]
    public ?string $date = null;

    #[Validate('required|string')]
    public ?string $time = null;

    #[Validate('required|integer|min:1|max:20')]
    public int $pax = 1;

    #[Validate('required|string')]
    public ?string $location = null;

    #[Validate('nullable|string|max:500')]
    public ?string $locationDetails = null;

    #[Validate('nullable|string|max:1000')]
    public ?string $additionalInfo = null;

    public function submit(): void
    {
        try {
            $this->validate();
            $this->nextStep();
        } catch (ValidationException $e) {
            Toaster::error('Please fill in all required fields.');
            return;
        }
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Photoshoot Details',
        ];
    }

    public function render()
    {
        $timeSlots = [
            ['id' => '08:00', 'name' => '08:00 AM'],
            ['id' => '09:00', 'name' => '09:00 AM'],
            ['id' => '10:00', 'name' => '10:00 AM'],
            ['id' => '11:00', 'name' => '11:00 AM'],
            ['id' => '12:00', 'name' => '12:00 PM'],
            ['id' => '13:00', 'name' => '01:00 PM'],
            ['id' => '14:00', 'name' => '02:00 PM'],
            ['id' => '15:00', 'name' => '03:00 PM'],
            ['id' => '16:00', 'name' => '04:00 PM'],
            ['id' => '17:00', 'name' => '05:00 PM'],
        ];

        $locations = [
            ['id' => 'hotel', 'name' => 'Hotel Lobby'],
            ['id' => 'airport', 'name' => 'Airport'],
            ['id' => 'landmark', 'name' => 'Famous Landmark'],
            ['id' => 'other', 'name' => 'Other Location'],
        ];

        return view('livewire.front.reserve.step.photoshoot-details', [
            'package' => $this->state()->packageStates(),
            'timeSlots' => $timeSlots,
            'locations' => $locations,
        ]);
    }
}
