<?php

namespace App\Livewire\Reserved;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reservation Details')]
class Show extends Component
{
    public Reservation $reservation;
    public ?string $driveLink = null;

    public function mount(Reservation $reservation): void
    {
        abort_unless($reservation->user_id === Auth::id(), 403);

        $this->reservation = $reservation->load([
            'detail.city', 
            'detail.moment', 
            'detail.package', 
            'detail.photographer',
            'payment'
        ]);

        if ($this->reservation->status->value === 'completed') {
            $this->driveLink = $this->reservation->detail?->drive_link;
        }
    }

    public function render()
    {
        return view('livewire.reserved.show');
    }
}
