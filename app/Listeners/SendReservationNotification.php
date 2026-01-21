<?php

namespace App\Listeners;

use App\Events\ReservationStatusChanged;
use App\Notifications\Reservation\ReservationStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReservationNotification implements ShouldQueue
{
    public function handle(ReservationStatusChanged $event): void
    {
        $user = $event->reservation->user;

        if ($user) {
            $user->notify(new ReservationStatusNotification($event->reservation));
        }
    }
}
