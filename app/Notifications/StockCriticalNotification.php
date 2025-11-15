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
    // Obtener el producto relacionado con la alerta
    $product = $this->alert->product;

    return [
        'alert_id'   => $this->alert->id,
        'title'      => 'Stock Crítico', // Título de la notificación
        'message'    => "El producto {$product->nombre} (Ref: {$product->referencia}) tiene stock crítico: {$product->stock_actual} unidades.",
        'icon'       => 'exclamation-triangle', // Icono de alerta
        'product_id' => $product->id,
        'estado'     => $this->alert->estado,
    ];
    }
}
