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
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard general
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Dashboard administrador
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('admin')
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Módulo de Inventario Crítico
    |--------------------------------------------------------------------------
    */

    // 1. Listado de productos (todos los roles)
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // 2. Registrar salida de inventario
    Route::post('/products/{product}/output', [ProductController::class, 'registerOutput'])
        ->middleware('can:registerOutput,product')
        ->name('products.output');

    // 3. Acciones de supervisores: Crear y eliminar
    Route::middleware(['can:create,App\Models\Product'])->group(function () {

        // Crear producto
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');

        // Actualizar solo stock mínimo
        Route::put('/products/{product}/min_stock', [ProductController::class, 'updateMinStock'])
            ->name('products.update.min_stock');

        // Eliminar producto
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // 4. Editar y actualizar producto (requiere permiso update sobre el producto específico)
    Route::middleware(['can:update,product'])->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    });

    // 5. Rutas de alertas
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/alerts/{alert}', [AlertController::class, 'show'])->name('alerts.show');

    // 6. Rutas de notificaciones
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/read_all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read.all');
});
