<?php

namespace App\Livewire\Reserved;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

#[Title('My Reservations')]
class Index extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    #[Computed]
    public function reservations()
    {
        return Reservation::where('user_id', Auth::id())
            ->with(['detail.city', 'detail.moment', 'detail.package', 'payment'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);
    }

    public function submit(string $reservationId, string $snapToken): void
    {
        $this->dispatch('open-snap-popup', token: $snapToken, reservationId: $reservationId);
    }

    #[On('payment-success')]
    public function handlePaymentSuccess(string $reservationId, array $result): void
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$reservation) {
            Toaster::error('Reservation not found.');
            return;
        }

        $reservation->update([
            'status' => ReservationStatus::Confirmed,
            'confirmed_at' => now(),
        ]);

        $reservation->payment->update([
            'payment_status' => PaymentStatus::Settlement,
            'paid_at' => now(),
        ]);

        event(new \App\Events\ReservationStatusChanged($reservation));

        Toaster::success('Payment successful! Your reservation is confirmed.');
    }

    #[On('payment-pending')]
    public function handlePaymentPending(array $result): void
    {
        Toaster::info('Payment is pending. Please complete your payment.');
    }

    #[On('payment-error')]
    public function handlePaymentError(string $reservationId, array $result): void
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($reservation && $reservation->payment) {
            $reservation->payment->update([
                'payment_status' => PaymentStatus::Failure,
                'gateway_response' => $result,
            ]);
        }

        event(new \App\Events\ReservationStatusChanged($reservation));

        Toaster::error('Payment failed. Please try again.');
    }

    #[On('payment-closed')]
    public function handlePaymentClosed(): void
    {
        Toaster::info('Payment was not completed. You can try again later.');
    }

    public function render()
    {
        return view('livewire.reserved.index');
    }
}
