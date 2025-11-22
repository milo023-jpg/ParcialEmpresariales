<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tarjetas de estadísticas principales --}}
                {{-- Tarjetas de estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6">

        {{-- Cantidad de productos --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Cantidad de productos</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalProducts }}</p>
        </div>

        {{-- Stock crítico --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Productos con stock crítico</p>
            <p class="mt-2 text-3xl font-bold text-red-600">{{ $lowStock }}</p>
        </div>

        {{-- Próximos a caducar --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Próximos a caducar (7 días)</p>
            <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $nearExpiration }}</p>
        </div>

        {{-- Caducados --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Productos caducados</p>
            <p class="mt-2 text-3xl font-bold text-purple-600">{{ $expired }}</p>
        </div>

        {{-- Alertas activas --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Alertas activas</p>
            <p class="mt-2 text-3xl font-bold text-orange-500">{{ $activeAlerts }}</p>
        </div>

        {{-- Usuarios registrados --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-sm text-gray-500">Usuarios registrados</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
        </div>

    </div>


            {{-- Listado de productos con stock crítico --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Productos con stock crítico</h3>

                    @if($criticalProducts->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-2 text-left">Nombre</th>
                                        <th class="py-2 text-left">Referencia</th>
                                        <th class="py-2 text-right">Stock actual</th>
                                        <th class="py-2 text-right">Stock mínimo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($criticalProducts as $product)
                                        <tr class="border-b">
                                            <td class="py-2">{{ $product->nombre }}</td>
                                            <td class="py-2">{{ $product->referencia }}</td>
                                            <td class="py-2 text-right">{{ $product->stock_actual }}</td>
                                            <td class="py-2 text-right">{{ $product->stock_minimo }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No hay productos con stock crítico 🎉</p>
                    @endif
                </div>
            </div>

            {{-- Listado de productos próximos a caducar --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Próximos a caducar (7 días)</h3>

                    @if($soonToExpire->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-2 text-left">Nombre</th>
                                        <th class="py-2 text-left">Referencia</th>
                                        <th class="py-2 text-left">Fecha caducidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($soonToExpire as $product)
                                        <tr class="border-b">
                                            <td class="py-2">{{ $product->nombre }}</td>
                                            <td class="py-2">{{ $product->referencia }}</td>
                                            <td class="py-2">
                                                {{ optional($product->fecha_caducidad)->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No hay productos próximos a caducar.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
