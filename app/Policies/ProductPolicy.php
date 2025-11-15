<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Si el usuario es administrador, tiene permiso absoluto sobre todo.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    /**
     * Todos los usuarios autenticados pueden ver el inventario.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Todos pueden ver un producto individual.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Crear productos:
     * ❌ Solo admin (por "before").
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Registrar salidas:
     * ✔ usuario puede
     * ✔ admin puede (por before)
     */
    public function registerOutput(User $user, Product $product): bool
    {
        return $user->hasRole('usuario');
    }

    /**
     * Registrar entradas (si la vas a implementar)
     * ✔ usuario puede
     */
    public function registerInput(User $user, Product $product): bool
    {
        return $user->hasRole('usuario');
    }

    /**
     * EDITAR producto:
     * ✔ usuario puede acceder a la pantalla de edición
     * ❌ admin ya tiene permiso total por before()
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('usuario');
    }

    /**
     * Eliminar producto:
     * ❌ usuario NO puede
     * ✔ admin puede (por before)
     */
    public function delete(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Ajustar stock mínimo:
     * ❌ usuario NO puede
     * ✔ admin puede (por before)
     */
    public function updateStockMinimo(User $user, Product $product): bool
    {
        return false;
    }
}
