<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your Order #' . $this->order['id'] . ' has been shipped!')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('Your order has been shipped.')
                    ->line('Tracking Number: ' . $this->order['tracking_number'])
                    ->action('Track Order', url('/orders/' . $this->order['id']))
                    ->line('Thank you for shopping with us!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Shipped',
            'message' => 'Your order #' . $this->order['id'] . ' has been shipped.',
            'order_id' => $this->order['id'],
            'tracking_number' => $this->order['tracking_number'],
            'type' => 'order_shipped',
            'icon' => 'truck',
        ];
    }
}