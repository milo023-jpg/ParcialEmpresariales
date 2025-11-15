<div wire:poll.5s> {{-- Recargar cada 5 segundos para actualizar las alertas --}}
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            @if ($notificationCount > 0)
                <span class="badge bg-danger">{{ $notificationCount }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
            @forelse ($unreadNotifications as $notification)
                <li>
                    {{-- Usa la ruta de markAsRead que definimos en NotificationController --}}
                    <a class="dropdown-item d-flex align-items-start" href="#" 
                       onclick="event.preventDefault(); document.getElementById('read-form-{{ $notification->id }}').submit();">
                        
                        <i class="fas fa-{{ $notification->data['icon'] ?? 'info-circle' }} me-2 text-danger"></i>
                        <div>
                            <strong class="text-danger">{{ $notification->data['title'] ?? 'Alerta' }}</strong>
                            <p class="mb-0 text-wrap" style="font-size: 0.85em;">{{ $notification->data['message'] }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                    {{-- Formulario oculto para enviar la solicitud POST --}}
                    <form id="read-form-{{ $notification->id }}" method="POST" action="{{ route('notifications.read', $notification->id) }}" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li><hr class="dropdown-divider"></li>
            @empty
                <li><span class="dropdown-item">No hay alertas nuevas.</span></li>
            @endforelse
            
            @if ($notificationCount > 0)
                <li>
                    <a class="dropdown-item text-center text-muted" href="#" wire:click="markAllAsRead">
                        Marcar todas como leídas
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>