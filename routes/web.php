<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web de la aplicación.
| Estas rutas son cargadas por el RouteServiceProvider.
|
*/

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// 🔒 Grupo protegido con autenticación y verificación de correo
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 📄 Dashboard general (usuarios normales)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 🛡️ Dashboard exclusivo para administradores
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('admin')
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | 🧩 Módulo de Inventario Crítico
    |--------------------------------------------------------------------------
    | Incluye la gestión de productos y alertas. Solo accesible por usuarios
    | autenticados con permiso de administrador.
    */
    Route::middleware(['admin'])->group(function () {
        // CRUD de productos críticos
        Route::resource('products', ProductController::class);

        // Listado de alertas activas
        Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔔 Módulo de Notificaciones
    |--------------------------------------------------------------------------
    | Accesible para cualquier usuario autenticado.
    */
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
});
