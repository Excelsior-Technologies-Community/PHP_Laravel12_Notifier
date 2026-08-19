<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaidNotification extends Notification
{
    use Queueable;

    protected array $notificationData;

    public function __construct(array $notificationData = [])
    {
        $this->notificationData = $notificationData;
    }

    public function via(object $notifiable): array
    {
        $preferences = $notifiable->getOrCreateNotificationPreference();

        if (! $preferences->invoice_paid_enabled) {
            return [];
        }

        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(
                $this->notificationData['title'] ?? 'Invoice Paid'
            )
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line(
                $this->notificationData['message']
                    ?? 'Your invoice has been paid.'
            )
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->notificationData['title'] ?? 'Invoice Paid',
            'message' => $this->notificationData['message']
                ?? 'Your invoice has been paid.',
            'type' => $this->notificationData['type']
                ?? 'invoice_paid',
            'icon' => $this->notificationData['icon']
                ?? 'credit-card',
        ];
    }
}