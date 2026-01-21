<?php

namespace App\Events;

use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Reservation $reservation,
    ) {}
}
