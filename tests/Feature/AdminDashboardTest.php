<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'name' => 'AdminTest',
            'email' => 'admintest@example.com',
        ]);

        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Bienvenido');
        $response->assertSee($admin->name);
    }

    public function test_user_is_redirected_from_admin_dashboard()
    {
        $user = User::factory()->create([
            'name' => 'UserTest',
            'email' => 'usertest@example.com',
        ]);

        $user->assignRole('usuario');

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Acceso denegado');
    }
}
