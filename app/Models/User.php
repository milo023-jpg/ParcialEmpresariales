<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * Atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atributos que se ocultan en arrays o JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Atributos adicionales que se agregan al modelo.
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Guard name para Spatie Permissions.
     */
    protected $guard_name = 'web';

    /**
     * Casting de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ============================================================
     | 🔹 RELACIONES DEL MÓDULO MIC (Inventario Crítico)
     |============================================================ */

    /**
     * Un usuario puede registrar muchos productos.
     * Relación: 1 usuario → N productos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Un usuario tiene muchas alertas a través de sus productos.
     * Relación: 1 usuario → N productos → N alertas
     */
    public function alerts()
    {
        return $this->hasManyThrough(Alert::class, Product::class);
    }
}
