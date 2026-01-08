<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Welcome to Our Application!')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('Thank you for registering with us.')
                    ->action('Get Started', url('/dashboard'))
                    ->line('If you have any questions, feel free to contact us.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome!',
            'message' => 'Thank you for joining our application.',
            'type' => 'welcome',
            'icon' => 'user-plus',
        ];
    }
}