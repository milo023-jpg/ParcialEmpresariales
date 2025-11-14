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

    /**
     * Canales por los que se enviará la notificación
     */
    public function via($notifiable)
    {
        return ['database']; 
        // Si necesitas correo, usa:
        // return ['database', 'mail'];
    }

    /**
     * Notificación almacenada en base de datos
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Stock Crítico',
            'message' => $this->alert->mensaje,
            'product_id' => $this->alert->product_id,
            'alert_id' => $this->alert->id,
            'icon' => 'alert-triangle',
            'url' => route('alerts.show', $this->alert->id),
        ];
    }

    /**
     * Notificación por email (opcional)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ Alerta de Stock Crítico')
            ->line($this->alert->mensaje)
            ->action('Ver alerta', route('alerts.show', $this->alert->id));
    }
}
