<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\StockCriticalNotification;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'mensaje',
        'estado',
        'fecha_generada'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación del UML: 1 alerta → N notificaciones
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Notifica a los admins (Laravel Notifications)
    public function notificarUsuarios()
    {
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new StockCriticalNotification($this));
        }
    }
}
