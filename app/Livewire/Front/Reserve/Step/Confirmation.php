<?php

namespace App\Livewire\Front\Reserve\Step;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use Spatie\LivewireWizard\Components\StepComponent;

class Confirmation extends StepComponent
{
    public ?string $reservationId = null;


    

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

            $this->reservationId = $reservation->id;
            $snapToken = $reservation->payment->gateway_response['snap_token'];
            
            $this->dispatch('open-snap-popup', token: $snapToken);
        } catch (\Exception $e) {
            Toaster::error('Failed to create reservation. Please try again.' .$e->getMessage());
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


        #[On('payment-success')]
    public function handlePaymentSuccess(array $result): void
    {
        if (!$this->reservationId) {
            Toaster::error('Reservation not found.');
            return;
        }

        $reservation = Reservation::find($this->reservationId);

        if (!$reservation) {
            Toaster::error('Reservation not found.');
            return;
        }

        $reservation->update([
            'status' => ReservationStatus::Confirmed,
            'confirmed_at' => now(),
        ]);

        $reservation->payment->update([
            'payment_status' => PaymentStatus::Paid,
            'paid_at' => now(),
        ]);

        Toaster::success('Payment successful! Your reservation is confirmed.');
        $this->redirect(route('reserved.index'));
    }

    #[On('payment-pending')]
    public function handlePaymentPending(array $result): void
    {
        Toaster::info('Payment is pending. Please complete your payment.');
        $this->redirect(route('reserved.index'));
    }

    #[On('payment-error')]
    public function handlePaymentError(array $result): void
    {
        if ($this->reservationId) {
            $reservation = Reservation::find($this->reservationId);
            if ($reservation && $reservation->payment) {
                $reservation->payment->update([
                    'payment_status' => PaymentStatus::Failed,
                    'gateway_response' => $result,
                ]);
            }
        }

        Toaster::error('Payment failed. Please try again.');
    }

    #[On('payment-closed')]
    public function handlePaymentClosed(): void
    {
        Toaster::info('Payment was not completed. You can continue payment from your reservations.');
        $this->redirect(route('reserved.index'));
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

