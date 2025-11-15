<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Marca una notificación específica como leída y redirige al destino.
     * * Usamos Route Model Binding para resolver automáticamente el UUID de la notificación.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // 1. Verificación de Propiedad (Seguridad)
        // Asegura que la notificación pertenezca al usuario autenticado.
        if (Auth::id() !== $notification->notifiable_id) {
            // Si no pertenece, lanza un error de acceso no autorizado.
            abort(403, 'This notification does not belong to you.');
        }

        // 2. Marcar como leída
        $notification->markAsRead();

        // 3. Redireccionar al destino de la alerta
        // La URL fue guardada en el campo 'data' de la notificación.
        $targetUrl = $notification->data['url'] ?? route('dashboard'); 
        // Si no hay 'url', redirige al dashboard por defecto.
        
        return redirect($targetUrl);
    }
    
    /**
     * Marca todas las notificaciones NO LEÍDAS del usuario como leídas.
     */
    public function markAllAsRead()
    {
        // Usa la relación notifiable que tiene el modelo User
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Todas las alertas han sido procesadas.');
    }
}