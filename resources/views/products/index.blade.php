<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Inventario Crítico (MIC)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensajes --}}
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Botón Registrar --}}
            @can('create', App\Models\Product::class)
                <a href="{{ route('products.create') }}" 
                   class="inline-flex items-center px-4 py-2 mb-6 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-plus me-2"></i> Registrar Nuevo Producto Crítico
                </a>
            @endcan

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre / Ref.</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Stock Actual</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Mínimo Alerta</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caducidad</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $p)
                            @php
                                $isCritical = $p->stock_actual <= $p->stock_minimo;
                                $isExpiringSoon = $p->fecha_caducidad && \Carbon\Carbon::parse($p->fecha_caducidad)->subDays(30)->isPast();
                                $rowClass = $isCritical ? 'bg-red-50 hover:bg-red-100' : ($isExpiringSoon ? 'bg-yellow-50 hover:bg-yellow-100' : 'hover:bg-gray-50');
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $p->nombre }}
                                    <div class="text-xs text-gray-500">({{ $p->referencia }})</div>
                                </td>

                                {{-- Stock Actual --}}
                                <td class="px-6 py-4 whitespace-nowrap text-lg font-bold">
                                    @if($isCritical)
                                        <i class="fas fa-exclamation-triangle text-red-600 me-1" title="Stock Crítico"></i>
                                    @endif
                                    {{ $p->stock_actual }}
                                </td>

                                {{-- Stock Mínimo --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->stock_minimo }}
                                </td>

                                {{-- Caducidad --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm {{ $isExpiringSoon ? 'text-yellow-700 font-semibold' : 'text-gray-500' }}">
                                    {{ $p->fecha_caducidad ? \Carbon\Carbon::parse($p->fecha_caducidad)->format('d/m/Y') : 'N/A' }}
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap"> 
                                    <div class="flex items-center gap-2">
                                    
                                        {{-- Salida Inventario --}}
                                        @can('registerOutput', $p)
                                        <form method="POST" action="{{ route('products.output', $p) }}" class="flex items-center gap-2">
                                            @csrf
                                            <input type="number" name="quantity" min="1" max="{{ $p->stock_actual }}" placeholder="Unidades" required
                                                   class="w-20 px-2 py-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-indigo-500 rounded-md hover:bg-indigo-600">
                                                Salida
                                            </button>
                                        </form>
                                        @endcan
                                    
                                        {{-- Editar --}}
                                        @can('update', $p)
                                        <a href="{{ route('products.edit', $p) }}" 
                                           class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                            Editar
                                        </a>
                                        @endcan
                                    
                                        {{-- Eliminar --}}
                                        @can('delete', $p)
                                        <form method="POST" action="{{ route('products.destroy', $p) }}" onsubmit="return confirm('¿Seguro de eliminar?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                                Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                    
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No hay productos registrados en el inventario crítico.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>