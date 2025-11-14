@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- 🧭 Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Panel de Administración</h1>
            <p class="text-gray-600 mt-2">Bienvenido, {{ Auth::user()->name }} 👋</p>
        </div>

        <!-- 📊 Resumen general -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Productos -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Productos Registrados</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $totalProducts ?? 0 }}
                        </p>
                    </div>
                    <x-lucide-package class="w-10 h-10 text-blue-500" />
                </div>
            </div>

            <!-- Bajo stock -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Productos con Bajo Stock</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $lowStock ?? 0 }}
                        </p>
                    </div>
                    <x-lucide-alert-triangle class="w-10 h-10 text-yellow-500" />
                </div>
            </div>

            <!-- Alertas activas -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Alertas Activas</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $activeAlerts ?? 0 }}
                        </p>
                    </div>
                    <x-lucide-bell-ring class="w-10 h-10 text-red-500" />
                </div>
            </div>

            <!-- Usuarios registrados -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Usuarios Registrados</h2>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $totalUsers ?? 0 }}
                        </p>
                    </div>
                    <x-lucide-users class="w-10 h-10 text-green-500" />
                </div>
            </div>
        </div>

        <!-- 📦 Accesos directos -->
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow p-6 text-center transition">
                <x-lucide-package class="w-10 h-10 mx-auto mb-2" />
                <h3 class="text-lg font-semibold">Gestión de Productos</h3>
            </a>

            <a href="{{ route('alerts.index') }}" class="bg-red-600 hover:bg-red-700 text-white rounded-xl shadow p-6 text-center transition">
                <x-lucide-bell-ring class="w-10 h-10 mx-auto mb-2" />
                <h3 class="text-lg font-semibold">Ver Alertas Críticas</h3>
            </a>

            <a href="{{ url('/notifications') }}" class="bg-gray-800 hover:bg-gray-900 text-white rounded-xl shadow p-6 text-center transition">
                <x-lucide-bell class="w-10 h-10 mx-auto mb-2" />
                <h3 class="text-lg font-semibold">Centro de Notificaciones</h3>
            </a>
        </div>
    </div>
</div>
@endsection
