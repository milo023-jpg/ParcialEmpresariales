<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alert;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'referencia',
        'stock_actual',
        'stock_minimo',
        'fecha_caducidad',
        'user_id'
    ];

    // 🔹 Esto convierte automáticamente la fecha en objeto Carbon
    protected $casts = [
        'fecha_caducidad' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function alerts() {
        return $this->hasMany(Alert::class);
    }

    // 🔹 Verifica si el stock es crítico
    public function verificarStock() {
        if ($this->stock_actual <= $this->stock_minimo) {
            $this->crearAlerta();
        }
    }

    // 🔹 Genera la alerta y la notificación
    public function crearAlerta() {
        $alerta = Alert::create([
            'product_id' => $this->id,
            'mensaje' => "El producto {$this->nombre} tiene un stock crítico ({$this->stock_actual})",
            'estado' => 'activa',
        ]);

        $alerta->notificarUsuarios();
    }
}
