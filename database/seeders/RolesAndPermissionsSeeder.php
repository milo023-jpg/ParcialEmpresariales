<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar cache de permisos (si existiera)
        try {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        } catch (\Throwable $e) {
            // ignore if package not yet published
        }

        // Crear permiso
        $perm = Permission::firstOrCreate(['name' => 'acceso-admin-dashboard', 'guard_name' => 'web']);

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $usuario = Role::firstOrCreate(['name' => 'usuario', 'guard_name' => 'web']);

        // Asignar permiso al rol admin
        if (! $admin->hasPermissionTo($perm->name)) {
            $admin->givePermissionTo($perm->name);
        }

        // Crear usuarios solicitados y asignar roles
        $adminUser = User::firstOrCreate([
            'email' => 'admin@test.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('12345678'),
        ]);

        $normalUser = User::firstOrCreate([
            'email' => 'user@test.com',
        ], [
            'name' => 'Usuario',
            'password' => bcrypt('12345678'),
        ]);

        try {
            if (! $adminUser->hasRole('admin')) {
                $adminUser->assignRole('admin');
            }

            if (! $normalUser->hasRole('usuario')) {
                $normalUser->assignRole('usuario');
            }
        } catch (\Throwable $e) {
            // si las tablas no existen aún, saltar
        }
    }
}
