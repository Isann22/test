<?php

namespace App\Notifications\Photographer;

use App\Models\PhotographerApplicant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicantRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public PhotographerApplicant $applicant
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update on Your ' . config('app.name') . ' Application')
            ->greeting('Dear ' . $this->applicant->fullname . ',')
            ->line('Thank you for your interest in joining our team of photographers.')
            ->line('After careful consideration, we regret to inform you that we are unable to proceed with your application at this time.')
            ->line('This decision was not easy, as we received many qualified applications.')
            ->line('We encourage you to continue developing your skills and consider applying again in the future.')
            ->line('Thank you for taking the time to apply, and we wish you all the best in your photography journey.')
            ->salutation('Best regards, The ' . config('app.name') . ' Team');
    }
}
