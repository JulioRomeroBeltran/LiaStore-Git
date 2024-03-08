@extends('layouts.app')

@section('content')
    <main class="container text-center mt-5">
        <div class="card offset-lg-3 col-lg-6 p-4 shadow mt-n4">
            <h2 class="text-center">Historial de Pedidos</h2>

            <div class="card-body">
                @if($historialPedidos->isEmpty())
                    <p>No hay pedidos en el historial.</p>
                @else
                    <ul class="list-group text-left">
                        @foreach($historialPedidos as $pedido)
                            <li class="list-group-item">
                                Pedido #{{ $pedido->id }} - Total: ${{ $pedido->total }} MXN -
                                <a href="{{ route('pedidos.confirmacion', ['id' => $pedido->id]) }}">Ver detalles</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </main>
@endsection
