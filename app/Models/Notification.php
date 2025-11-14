<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Alert;

class StockCriticalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    public function via($notifiable)
    {
        return ['database']; // opcional: agregar 'mail'
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Stock Crítico',
            'message' => $this->alert->mensaje,
            'url' => route('alerts.show', $this->alert->id),
            'icon' => 'alert-triangle'
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ Alerta de Stock Crítico')
            ->line($this->alert->mensaje)
            ->action('Ver Detalle', route('alerts.show', $this->alert->id));
    }
}
