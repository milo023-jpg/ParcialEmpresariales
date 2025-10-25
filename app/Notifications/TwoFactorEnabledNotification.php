<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorEnabledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        // no payload needed for now
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Autenticación de dos pasos activada')
                    ->greeting('Hola ' . $notifiable->name . ',')
                    ->line('Se ha activado la autenticación en dos pasos en tu cuenta.')
                    ->action('Ir al panel', url('/dashboard'))
                    ->line('Si no activaste esta opción, por favor contacta con soporte.');
    }

    /**
     * Get the array representation of the notification for the database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => '2FA activada',
            'message' => 'Has activado la autenticación en dos pasos en tu cuenta.',
            'url' => url('/dashboard'),
            'icon' => 'shield-check',
        ];
    }
}
