<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsMenu extends Component
{
    public $unreadNotifications;
    public $notificationCount;

    // Se ejecuta cada vez que se carga el componente
    public function mount()
    {
        $this->loadNotifications();
    }
    
    // Se ejecuta al actualizar por polling (cada 5 segundos en este caso)
    public function loadNotifications()
    {
        if (Auth::check()) {
            // Cargar solo las 5 notificaciones no leídas más recientes
            $this->unreadNotifications = Auth::user()
                ->unreadNotifications()
                ->take(5)
                ->get();
                
            $this->notificationCount = Auth::user()->unreadNotifications()->count();
        } else {
            $this->unreadNotifications = collect();
            $this->notificationCount = 0;
        }
    }
    
    // Función para marcar todas las notificaciones como leídas (sin redirección)
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications(); // Recargar el estado
    }

    public function render()
    {
        // Se añade `poll.5s` para que el componente se recargue automáticamente cada 5 segundos.
        return view('livewire.notifications-menu');
    }
}