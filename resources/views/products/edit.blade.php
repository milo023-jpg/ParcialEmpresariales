<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto Crítico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-lg font-medium text-gray-900 mb-4">Formulario de Edición</h3>
                
                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')
                    @php
                        // Si es rol usuario → solo puede editar stock_actual
                        $soloLectura = auth()->user()->hasRole('usuario');
                    @endphp
                    {{-- Campo Nombre --}}
                    <div class="mb-4">
                        <x-label for="nombre" value="{{ __('Nombre') }}" />
                        <x-input id="nombre" 
                            class="block mt-1 w-full @if($soloLectura) bg-gray-100 text-gray-700 cursor-not-allowed @endif" 
                            type="text" 
                            name="nombre"
                            value="{{ old('nombre', $product->nombre) }}"
                            :readonly="$soloLectura" 
 />
                    </div>

                    {{-- Campo Referencia --}}
                    <div class="mb-4">
                        <x-label for="referencia" value="{{ __('Referencia') }}" />
                        <x-input id="referencia" 
                            class="block mt-1 w-full @if($soloLectura) bg-gray-100 text-gray-700 cursor-not-allowed @endif" 
                            type="text" 
                            name="referencia"
                            value="{{ old('referencia', $product->referencia) }}"
                            :readonly="$soloLectura" 
 />

                    </div>

                    {{-- Campo Stock Actual --}}
                    <div class="mb-4">
                        <x-label for="stock_actual" value="{{ __('Stock Actual') }}" />
                        <x-input id="stock_actual" class="block mt-1 w-full" type="number" name="stock_actual" min="0" 
                            value="{{ old('stock_actual', $product->stock_actual) }}" required />
                    </div>

                    {{-- Campo Stock Mínimo de Alerta --}}
                    <div class="mb-4">
                        <x-label for="stock_minimo" value="{{ __('Stock Mínimo de Alerta') }}" />
                        <x-input id="stock_minimo" 
                            class="block mt-1 w-full @if($soloLectura) bg-gray-100 text-gray-700 cursor-not-allowed @endif" 
                            type="number" 
                            name="stock_minimo"
                            value="{{ old('stock_minimo', $product->stock_minimo) }}"
                            :readonly="$soloLectura" 
 />

                    </div>

                    {{-- Campo Fecha de Caducidad --}}
                    <div class="mb-4">
                        <x-label for="fecha_caducidad" value="{{ __('Fecha de Caducidad (Opcional)') }}" />
                        {{-- Es crucial usar el formato 'Y-m-d' para el campo date y el operador optional() es más limpio --}}
                        <x-input id="fecha_caducidad" 
                            class="block mt-1 w-full @if($soloLectura) bg-gray-100 text-gray-700 cursor-not-allowed @endif" 
                            type="date" 
                            name="fecha_caducidad"
                            value="{{ old('fecha_caducidad', optional($product->fecha_caducidad)->format('Y-m-d')) }}"
                            :readonly="$soloLectura" 
 />

                    </div>
                    
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('products.index') }}" class="mr-4 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-md">
                            {{ __('Cancelar') }}
                        </a>
                        {{-- Usamos el componente <x-button> --}}
                        <x-button type="submit">
                            {{ __('Actualizar Producto') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>