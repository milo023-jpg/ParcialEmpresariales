<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Permite a los administradores y supervisores anular las políticas.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        // El Operario y el Supervisor pueden ver el inventario.
        //return $user->hasRole('operario') || $user->hasRole('supervisor');
        return true;
    }

    /**
     * Determinar si el usuario puede crear nuevos ingredientes/productos.
     * Solo los supervisores pueden añadir nuevos productos.
     */
    public function create(User $user): bool
    {
        // 🔹 Supervisor: Puede crear productos.
        return $user->hasRole('supervisor');
    }

    /**
     * Determinar si el usuario puede registrar salidas de inventario (registerOutput).
     * Esto lo hacen los operarios y supervisores al usar ingredientes.
     */
    public function registerOutput(User $user, Product $product): bool
    {
        // 🔹 Operario o Supervisor: Puede registrar el uso de productos.
        return $user->hasRole('operario') || $user->hasRole('supervisor') || $user->hasRole('admin');
    }

    /**
     * Determinar si el usuario puede modificar el stock mínimo de alerta (updateStockMinimo).
     * Solo el supervisor tiene la potestad de ajustar los umbrales de alerta.
     */
    public function updateStockMinimo(User $user, Product $product): bool
    {
        // 🔹 Supervisor: Únicamente puede establecer el stock mínimo.
        return $user->hasRole('supervisor');
    }
    
    /**
     * Determinar si el usuario puede editar la información completa del producto.
     */
    public function update(User $user, Product $product): bool
    {
        // 🔹 Supervisor: Puede modificar todos los campos.
        return $user->hasRole('supervisor');
    }

    /**
     * Determinar si el usuario puede eliminar un producto.
     */
    public function delete(User $user, Product $product): bool
    {
        // 🔹 Supervisor: Puede eliminar productos.
        return $user->hasRole('supervisor');
    }
}