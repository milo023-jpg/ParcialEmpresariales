<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    🍕 {{ __('Dashboard - Pizzería La Nonna') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Panel de control del inventario</p>
            </div>
            <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow">
                <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tarjetas de estadísticas principales --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">

                {{-- Cantidad de productos --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-blue-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $totalProducts }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Productos</p>
                    </div>
                </div>

                {{-- Stock crítico --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-red-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-red-100 dark:bg-red-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $lowStock }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Stock Crítico</p>
                    </div>
                </div>

                {{-- Próximos a caducar --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-yellow-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $nearExpiration }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Por Caducar (7d)</p>
                    </div>
                </div>

                {{-- Caducados --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-purple-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $expired }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Caducados</p>
                    </div>
                </div>

                {{-- Alertas activas --}}
                <div class="bg-white  rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-orange-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-orange-100 dark:bg-orange-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $activeAlerts }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Alertas Activas</p>
                    </div>
                </div>

                {{-- Usuarios registrados --}}
                <div class="bg-white  rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl border-l-4 border-green-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-green-100 dark:bg-green-900 rounded-lg p-2">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900  mb-1">{{ $totalUsers }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Usuarios</p>
                    </div>
                </div>

            </div>

            {{-- Resumen de alertas --}}
            @if($lowStock > 0 || $nearExpiration > 0 || $expired > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Alertas que Requieren Atención
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($lowStock > 0)
                    <div class="flex items-start p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                        <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-red-800">Stock Crítico</p>
                            <p class="text-sm text-red-700">{{ $lowStock }} productos necesitan reabastecimiento urgente</p>
                        </div>
                    </div>
                    @endif

                    @if($nearExpiration > 0)
                    <div class="flex items-start p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                        <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-yellow-800">Por Caducar</p>
                            <p class="text-sm text-yellow-700">{{ $nearExpiration }} productos caducan en los próximos 7 días</p>
                        </div>
                    </div>
                    @endif

                    @if($expired > 0)
                    <div class="flex items-start p-4 bg-purple-50 border-l-4 border-purple-400 rounded-r-lg">
                        <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-purple-800">Productos Caducados</p>
                            <p class="text-sm text-purple-700">{{ $expired }} productos ya han caducado y deben ser retirados</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Tablas de productos lado a lado --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                {{-- Listado de productos con stock crítico --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                        <h3 class="text-lg font-bold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Productos con Stock Crítico
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($criticalProducts->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-b-2 border-gray-200">
                                            <th class="py-3 text-left text-xs font-semibold text-gray-600 uppercase">Producto</th>
                                            <th class="py-3 text-left text-xs font-semibold text-gray-600 uppercase">Referencia</th>
                                            <th class="py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actual</th>
                                            <th class="py-3 text-right text-xs font-semibold text-gray-600 uppercase">Mínimo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($criticalProducts as $product)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="py-3 text-sm font-medium text-gray-900">{{ $product->nombre }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $product->referencia }}</td>
                                                <td class="py-3 text-sm text-right">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $product->stock_actual }}
                                                    </span>
                                                </td>
                                                <td class="py-3 text-sm text-right text-gray-600">{{ $product->stock_minimo }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay productos con stock crítico 🎉</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Listado de productos próximos a caducar --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 px-6 py-4">
                        <h3 class="text-lg font-bold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Próximos a Caducar (7 días)
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($soonToExpire->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-b-2 border-gray-200">
                                            <th class="py-3 text-left text-xs font-semibold text-gray-600 uppercase">Producto</th>
                                            <th class="py-3 text-left text-xs font-semibold text-gray-600 uppercase">Referencia</th>
                                            <th class="py-3 text-left text-xs font-semibold text-gray-600 uppercase">Caducidad</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($soonToExpire as $product)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="py-3 text-sm font-medium text-gray-900">{{ $product->nombre }}</td>
                                                <td class="py-3 text-sm text-gray-600">{{ $product->referencia }}</td>
                                                <td class="py-3 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ optional($product->fecha_caducidad)->format('d/m/Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay productos próximos a caducar 👍</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>