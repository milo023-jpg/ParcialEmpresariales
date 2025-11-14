@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Alertas de Inventario</h2>
  <table class="table table-bordered">
    <thead><tr><th>Producto</th><th>Mensaje</th><th>Fecha</th><th>Estado</th></tr></thead>
    <tbody>
      @foreach($alerts as $a)
      <tr>
        <td>{{ $a->product->nombre }}</td>
        <td>{{ $a->mensaje }}</td>
        <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>
        <td><span class="badge bg-danger">{{ $a->estado }}</span></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
