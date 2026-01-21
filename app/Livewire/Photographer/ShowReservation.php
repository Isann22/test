<?php

namespace App\Livewire\Photographer;

use App\Models\ReservationDetail;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Mary\Traits\Toast;

#[Layout('components.layouts.dashboard')]
class ShowReservation extends Component
{
    use Toast;

    public ReservationDetail $reservationDetail;
    
    #[Validate('required|url|max:500')]
    public string $drive_link = '';

    public function mount(ReservationDetail $reservationDetail): void
    {
        // Ensure the photographer can only view their own reservations
        if ($reservationDetail->photographer_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $this->reservationDetail = $reservationDetail->load([
            'reservation.user',
            'city',
            'moment',
            'package',
            'photographer'
        ]);

        // Pre-fill existing drive link if available
        $this->drive_link = $reservationDetail->drive_link ?? '';
    }

    public function submitDriveLink(): void
    {
        $this->validate();

        // Update drive link
        $this->reservationDetail->update([
            'drive_link' => $this->drive_link,
        ]);

        // Update reservation status to completed
        $this->reservationDetail->reservation->update([
            'status' => ReservationStatus::Completed,
        ]);

        // Refresh the model
        $this->reservationDetail->refresh();
        $this->reservationDetail->load('reservation');

        $this->success('Drive link submitted successfully! Reservation status updated to Completed.');
    }

    public function render(): View
    {
        return view('livewire.photographer.show-reservation');
    }
}
