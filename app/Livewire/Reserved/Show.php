<?php

namespace App\Livewire\Reserved;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Reservation Details')]
class Show extends Component
{
    public Reservation $reservation;
    public ?string $driveLink = null;
    public ?int $rating = null;
    public bool $hasRated = false;

    public function mount(Reservation $reservation): void
    {
        abort_unless($reservation->user_id === Auth::id(), 403);

        $this->reservation = $reservation->load([
            'detail.city', 
            'detail.moment', 
            'detail.package', 
            'detail.photographer.photographerProfile',
            'payment'
        ]);

        if ($this->reservation->status->value === 'completed') {
            $this->driveLink = $this->reservation->detail?->drive_link;
        }
    }

    public function submitRating(): void
    {
        if ($this->reservation->status->value !== 'completed') {
            Toaster::error('Rating can only be submitted for completed reservations.');
            return;
        }

        if (!$this->rating || $this->rating < 1 || $this->rating > 5) {
            Toaster::error('Please select a rating between 1 and 5 stars.');
            return;
        }

        $photographer = $this->reservation->detail?->photographer;
        
        if (!$photographer || !$photographer->photographerProfile) {
            Toaster::error('Photographer not found.');
            return;
        }

        $photographer->photographerProfile->update([
            'rating' => $this->rating
        ]);

        $this->hasRated = true;
        Toaster::success('Thank you for rating your photographer!');
    }

    public function render()
    {
        return view('livewire.reserved.show');
    }
}
