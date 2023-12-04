<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invitationToken;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $invitationToken)
    {
        $this->invitationToken = $invitationToken;
    }

    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have been invited to join the team.')
            ->action('Create your account now', url(config('app.front_end_url') . '/users/create/' . $this->invitationToken))
            ->line('Good luck!');
    }
}
