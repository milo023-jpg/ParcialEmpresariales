<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StockCriticalNotification extends Notification
{
    use Queueable;

    public $alert;

    public function __construct($alert)
    {
        $this->alert = $alert;
    }

    public function via($notifiable)
    {
        return ['database']; // << ESTA ES LA CLAVE
    }

    public function toDatabase($notifiable)
    {
        return [
            'alert_id' => $this->alert->id,
            'mensaje' => $this->alert->mensaje,
            'product_id' => $this->alert->product_id,
            'estado' => $this->alert->estado,
        ];
    }
}
