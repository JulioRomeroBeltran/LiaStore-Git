@extends('layouts.adminapp')

@section('content')
<div style="margin-top: 100px;"></div>
<main class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center">Historial de Todos los Pedidos</h2>

        <div class="card-body">
            @if($todosLosPedidos->isEmpty())
            <p>No hay pedidos en el historial.</p>
            @else
            <ul class="list-group">
                @foreach($todosLosPedidos as $pedido)
                <li class="list-group-item">
                    {{ $pedido->cliente ? $pedido->cliente->name : 'Usuario eliminado' }} - Pedido #{{ $pedido->id }} - Total: ${{ $pedido->total }} MXN -
                    <a href="{{ route('pedidos.confirmacion', ['id' => $pedido->id]) }}">Ver detalles</a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</main>
@endsection