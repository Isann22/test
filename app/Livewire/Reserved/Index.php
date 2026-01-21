<?php

namespace App\Livewire\Reserved;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\Attributes\On;
use App\Enums\PaymentStatus;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Enums\ReservationStatus;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;


#[Title('My Reservations')]
class Index extends Component
{
    use WithPagination;

    public string $statusFilter = '';
    public bool $showCancelModal = false;
    public ?string $reservationIdToCancel = null;

    #[Computed]
    public function reservations()
    {
        return Reservation::where('user_id', Auth::id())
            ->with(['detail.city', 'detail.moment', 'detail.package', 'payment'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);
    }

    public function openCancelModal(string $reservationId): void
    {
        $this->reservationIdToCancel = $reservationId;
        $this->showCancelModal = true;
    }

    public function closeCancelModal(): void
    {
        $this->showCancelModal = false;
        $this->reservationIdToCancel = null;
    }

    public function confirmCancel(): void
    {
        $reservation = Reservation::where('id', $this->reservationIdToCancel)
            ->where('user_id', Auth::id())
            ->first();

        if (!$reservation) {
            Toaster::error('Reservation not found.');
            $this->closeCancelModal();
            return;
        }

        if (Carbon::parse($reservation->created_at)->addDays(2)->isPast()) {
            Toaster::error('Cancellation period has expired (2 days from booking).');
            $this->closeCancelModal();
            return;
        }

        $reservation->cancelled_at = now();
        $reservation->status = ReservationStatus::Cancelled;
        $reservation->save();

        $this->closeCancelModal();
        Toaster::success('Reservation has been successfully canceled.');
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
