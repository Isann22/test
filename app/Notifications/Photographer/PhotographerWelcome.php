<?php

namespace App\Notifications\Photographer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PhotographerWelcome extends Notification implements ShouldQueue
{
    use Queueable;

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
            ->subject('Welcome to ' . config('app.name') . ' - You\'re Hired!')
            ->greeting('Congratulations, ' . $notifiable->name . '!')
            ->line('We are excited to welcome you to our team of photographers.')
            ->line('Your application has been approved and your account is now active.')
            ->line('To get started, please set your password by clicking the button below:')
            ->action('Set Your Password', url('/forgot-password'))
            ->line('Once you\'ve set your password, you can log in and start accepting photo sessions.')
            ->line('If you have any questions, feel free to contact our support team.')
            ->salutation('Welcome aboard!');
    }
}
