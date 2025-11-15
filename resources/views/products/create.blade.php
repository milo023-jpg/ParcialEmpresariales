<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Producto Crítico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                {{-- Aquí va el formulario de creación (Nombre, Referencia, Stock, Mínimo, Caducidad) --}}
                <h3 class="text-lg font-medium text-gray-900 mb-4">Formulario de Registro</h3>
                
                {{-- Ejemplo de formulario básico, adapta las rutas si son diferentes --}}
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    
                    {{-- Campo Nombre --}}
                    <div class="mb-4">
                        <x-label for="nombre" value="{{ __('Nombre') }}" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" required />
                    </div>

                    {{-- Campo Referencia --}}
                    <div class="mb-4">
                        <x-label for="referencia" value="{{ __('Referencia') }}" />
                        <x-input id="referencia" class="block mt-1 w-full" type="text" name="referencia" required />
                    </div>

                    {{-- Campo Stock Actual --}}
                    <div class="mb-4">
                        <x-label for="stock_actual" value="{{ __('Stock Actual') }}" />
                        <x-input id="stock_actual" class="block mt-1 w-full" type="number" name="stock_actual" min="0" required />
                    </div>

                    {{-- Campo Stock Mínimo de Alerta --}}
                    <div class="mb-4">
                        <x-label for="stock_minimo" value="{{ __('Stock Mínimo de Alerta') }}" />
                        <x-input id="stock_minimo" class="block mt-1 w-full" type="number" name="stock_minimo" min="0" required />
                    </div>

                    {{-- Campo Fecha de Caducidad --}}
                    <div class="mb-4">
                        <x-label for="fecha_caducidad" value="{{ __('Fecha de Caducidad (Opcional)') }}" />
                        <x-input id="fecha_caducidad" class="block mt-1 w-full" type="date" name="fecha_caducidad" />
                    </div>
                    
                    <x-button class="mt-4">
                        {{ __('Guardar Producto') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>