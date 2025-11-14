<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Notifications\StockCriticalNotification;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'mensaje', 'estado'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    // 🔹 Notifica a todos los usuarios con rol admin
    public function notificarUsuarios() {
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new StockCriticalNotification($this));
        }
    }
}
