<?php

namespace App\Notifications\Reservation;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Reservation $reservation
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $reservation = $this->reservation->load(['detail.city', 'detail.moment', 'detail.package']);
        $status = $reservation->status;

        return match ($status) {
            ReservationStatus::Pending => $this->pendingMail($reservation),
            ReservationStatus::Confirmed => $this->confirmedMail($reservation),
            ReservationStatus::Completed => $this->completedMail($reservation),
            ReservationStatus::Cancelled => $this->cancelledMail($reservation),
            default => $this->defaultMail($reservation),
        };
    }

    protected function pendingMail(Reservation $reservation): MailMessage
    {
        return (new MailMessage)
            ->subject('Reservation Created - ' . $reservation->reservation_code)
            ->greeting('Hi ' . $reservation->user->name . '!')
            ->line('Your reservation has been successfully created.')
            ->line('**Reservation Code:** ' . $reservation->reservation_code)
            ->line('**Location:** ' . $reservation->detail->city->name)
            ->line('**Moment:** ' . $reservation->detail->moment->name)
            ->line('**Package:** ' . $reservation->detail->package->name)
            ->line('**Date:** ' . $reservation->detail->photoshoot_date->format('d M Y'))
            ->line('**Time:** ' . $reservation->detail->photoshoot_time->format('H:i'))
            ->line('**Total:** Rp ' . number_format($reservation->total_amount, 0, ',', '.'))
            ->line('Please complete your payment to confirm your booking.')
            ->action('View Reservation', url('/my-reservations/' . $reservation->id))
            ->line('Thank you for choosing us!');
    }

    protected function confirmedMail(Reservation $reservation): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Confirmed - ' . $reservation->reservation_code)
            ->greeting('Hi ' . $reservation->user->name . '!')
            ->line('Your payment has been successfully confirmed.')
            ->line('**Reservation Code:** ' . $reservation->reservation_code)
            ->line('**Location:** ' . $reservation->detail->city->name)
            ->line('**Moment:** ' . $reservation->detail->moment->name)
            ->line('**Date:** ' . $reservation->detail->photoshoot_date->format('d M Y'))
            ->line('**Time:** ' . $reservation->detail->photoshoot_time->format('H:i'))
            ->line('Our photographer will contact you before your session.')
            ->action('View Details', url('/my-reservations/' . $reservation->id))
            ->line('Thank you!');
    }

    protected function completedMail(Reservation $reservation): MailMessage
    {
        $driveLink = $reservation->detail->drive_link ?? '#';

        return (new MailMessage)
            ->subject('Your Photos are Ready! - ' . $reservation->reservation_code)
            ->greeting('Hi ' . $reservation->user->name . '!')
            ->line('Great news! Your photos are now ready to view.')
            ->line('**Reservation Code:** ' . $reservation->reservation_code)
            ->line('**Location:** ' . $reservation->detail->city->name)
            ->line('**Moment:** ' . $reservation->detail->moment->name)
            ->action('Download Photos', $driveLink)
            ->line('Thank you for using our service. We hope you love the results!');
    }

    protected function cancelledMail(Reservation $reservation): MailMessage
    {
        return (new MailMessage)
            ->subject('Reservation Cancelled - ' . $reservation->reservation_code)
            ->greeting('Hi ' . $reservation->user->name . ',')
            ->line('We are informing you that your reservation has been cancelled.')
            ->line('**Reservation Code:** ' . $reservation->reservation_code)
            ->line('**Location:** ' . $reservation->detail->city->name)
            ->line('**Moment:** ' . $reservation->detail->moment->name)
            ->line('If you have any questions, please feel free to contact us.')
            ->action('Contact Support', url('/'))
            ->line('Thank you.');
    }

    protected function defaultMail(Reservation $reservation): MailMessage
    {
        return (new MailMessage)
            ->subject('Reservation Update - ' . $reservation->reservation_code)
            ->greeting('Hi ' . $reservation->user->name . '!')
            ->line('Your reservation status has been updated to: ' . $reservation->status->label())
            ->action('View Reservation', url('/my-reservations/' . $reservation->id))
            ->line('Thank you!');
    }
}
