<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomTemplateNotification extends Notification
{
    use Queueable;

    public array $payload;

    /**
     * Create a new notification instance.
     *
     * $payload can contain:
     * - raw_title: string template
     * - raw_message: string template
     * - priority: info, success, warning, critical
     * - action_text: string (optional)
     * - action_url: string (optional)
     * - send_email: bool (optional)
     * - metadata: array (order_id, amount, date, etc.)
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (! empty($this->payload['send_email'])) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Parse template variables like {user_name}, {user_email}, {order_id}, etc.
     */
    protected function interpolate(string $text, object $notifiable): string
    {
        $metadata = $this->payload['metadata'] ?? [];

        $replacements = [
            '{user_name}'  => $notifiable->name ?? 'User',
            '{user_email}' => $notifiable->email ?? '',
            '{user_role}'  => ucfirst($notifiable->role ?? 'User'),
            '{user_status}'=> ucfirst($notifiable->status ?? 'Active'),
            '{order_id}'   => $metadata['order_id'] ?? 'ORD-0000',
            '{amount}'     => $metadata['amount'] ?? '₹0.00',
            '{date}'       => now()->format('d M, Y h:i A'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = $this->interpolate($this->payload['raw_title'] ?? 'Custom Notification', $notifiable);
        $message = $this->interpolate($this->payload['raw_message'] ?? '', $notifiable);

        $mail = (new MailMessage)
            ->subject($title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($message);

        if (! empty($this->payload['action_text']) && ! empty($this->payload['action_url'])) {
            $mail->action($this->payload['action_text'], url($this->payload['action_url']));
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification for database.
     */
    public function toArray(object $notifiable): array
    {
        $title = $this->interpolate($this->payload['raw_title'] ?? 'Custom Notification', $notifiable);
        $message = $this->interpolate($this->payload['raw_message'] ?? '', $notifiable);
        $priority = $this->payload['priority'] ?? 'info';

        $iconMap = [
            'info'     => 'info-circle',
            'success'  => 'check-circle',
            'warning'  => 'exclamation-triangle',
            'critical' => 'bolt',
        ];

        return [
            'title'       => $title,
            'message'     => $message,
            'type'        => 'custom_announcement',
            'priority'    => $priority,
            'icon'        => $iconMap[$priority] ?? 'bell',
            'action_text' => $this->payload['action_text'] ?? null,
            'action_url'  => $this->payload['action_url'] ?? null,
            'metadata'    => $this->payload['metadata'] ?? [],
        ];
    }
}
