@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Inventario Crítico</h2>

  <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nombre</th><th>Referencia</th><th>Stock</th><th>Mínimo</th><th>Caducidad</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
      <tr @if($p->stock_actual <= $p->stock_minimo) class="table-danger" @endif>
        <td>{{ $p->nombre }}</td>
        <td>{{ $p->referencia }}</td>
        <td>{{ $p->stock_actual }}</td>
        <td>{{ $p->stock_minimo }}</td>
        <td>{{ $p->fecha_caducidad }}</td>
        <td>
          @role('admin')
          <a href="{{ route('products.edit', $p) }}" class="btn btn-warning btn-sm">Editar</a>
          @endrole
          <form method="POST" action="{{ route('products.destroy', $p) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Eliminar</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
