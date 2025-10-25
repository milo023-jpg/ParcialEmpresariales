<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de administración</h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto py-8 px-4">
        <p class="mt-4">Bienvenido, {{ auth()->user()->name }}.</p>
        <p class="mt-2 text-sm text-gray-600">Solo usuarios con permiso <strong>acceso-admin-dashboard</strong> pueden ver esto.</p>
    </div>
</x-app-layout>
