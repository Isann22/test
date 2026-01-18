<?php

namespace App\Livewire\Front\Reserve\Step;

use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Masmerise\Toaster\Toaster;
use Spatie\LivewireWizard\Components\StepComponent;

class Confirmation extends StepComponent
{
    /**
     * Confirm and save the booking to database.
     */
    public function confirmBooking(ReservationService $reservationService): void
    {
        // 1. Collect all data from wizard state
        $bookingData = $this->collectBookingData();

        // 2. Server-side validation using Form Request rules
        $validator = Validator::make(
            $bookingData,
            (new StoreReservationRequest())->rules(),
            (new StoreReservationRequest())->messages()
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toaster::error($error);
            }
            return;
        }

        // 3. Check if user is authenticated
        if (!Auth::check()) {
            Toaster::error('Please login to continue.');
            $this->redirect(route('login'));
            return;
        }

        try {
            // 4. Create reservation using service
            $reservation = $reservationService->createReservation(
                $validator->validated(),
                Auth::id()
            );

            // 5. Success - redirect to reservations page
            Toaster::success('Reservation created successfully!');
            $this->redirect(route('reserved.index'));

        } catch (\Exception $e) {
            Toaster::error('Failed to create reservation. Please try again. ' . $e->getMessage());
            report($e); // Log error for debugging
        }
    }

    /**
     * Collect all booking data from wizard state.
     */
    private function collectBookingData(): array
    {
        $packageState = $this->state()->forStep('choose-package');
        $detailsState = $this->state()->forStep('photoshoot-details');

        return [
            // Package data
            'cityId' => $packageState['cityId'] ?? null,
            'momentId' => $packageState['momentId'] ?? null,
            'packageId' => $packageState['selectedPackageId'] ?? null,

            // Photoshoot details
            'date' => $detailsState['date'] ?? null,
            'time' => $detailsState['time'] ?? null,
            'pax' => $detailsState['pax'] ?? 1,
            'location' => $detailsState['location'] ?? null,
            'locationDetails' => $detailsState['locationDetails'] ?? null,
            'additionalInfo' => $detailsState['additionalInfo'] ?? null,
        ];
    }

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

