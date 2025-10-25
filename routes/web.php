<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Ruta protegida para administradores
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(\App\Http\Middleware\EnsureHasAdminPermission::class)->name('admin.dashboard');

    // Notifications: mark single as read
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});
