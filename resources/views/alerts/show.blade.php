@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-extrabold text-gray-800">
            🚨 Detalle de Alerta Crítica #{{ $alert->id }}
        </h2>
        <a href="{{ route('alerts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left me-2"></i> Volver al Historial
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- COLUMNA PRINCIPAL: Detalle de la Alerta --}}
        <div class="lg:col-span-2 bg-white shadow-xl sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4 border-b pb-2">Información del Incidente</h3>
            
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Fecha y Hora de Generación</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $alert->created_at->format('d/m/Y H:i:s') }}</dd>
                </div>
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Estado de la Alerta</dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if($alert->estado == 'activa') bg-red-100 text-red-800 @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($alert->estado) }}
                        </span>
                    </dd>
                </div>
                
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Mensaje Detallado</dt>
                    <dd class="mt-1 text-gray-800 border-l-4 border-red-500 pl-3 py-2 bg-red-50 rounded-md">
                        {{ $alert->mensaje }}
                    </dd>
                </div>
            </dl>
        </div>

        {{-- COLUMNA LATERAL: Producto Afectado --}}
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4 border-b pb-2">Ingrediente Afectado</h3>
            
            @if($alert->product)
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre del Producto</dt>
                        <dd class="mt-1 text-gray-900 font-semibold">{{ $alert->product->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Referencia</dt>
                        <dd class="mt-1 text-gray-700">{{ $alert->product->referencia }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stock Actual</dt>
                        <dd class="mt-1 text-2xl font-bold text-red-600">{{ $alert->product->stock_actual }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stock Mínimo</dt>
                        <dd class="mt-1 text-lg text-gray-700">{{ $alert->product->stock_minimo_alerta }}</dd>
                    </div>
                    
                    @can('update', $alert->product)
                    <div class="pt-4 border-t mt-4">
                        <a href="{{ route('products.edit', $alert->product) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-edit me-2"></i> Gestionar Stock (Supervisor)
                        </a>
                    </div>
                    @endcan
                </dl>
            @else
                <p class="text-sm text-gray-500">El producto relacionado con esta alerta ha sido eliminado.</p>
            @endif
        </div>
    </div>
</div>
@endsection