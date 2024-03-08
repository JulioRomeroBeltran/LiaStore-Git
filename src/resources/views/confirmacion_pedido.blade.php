@extends(Auth::check() && Auth::user()->role === 'admin' ? 'layouts.adminapp' : 'layouts.app')

@section('content')
<main class="container text-center mt-5">
    <div class="card offset-lg-3 col-lg-6 p-4 shadow mt-n4">
        <h2 class="text-center">Confirmación de Pedido</h2>

        <div class="card-body">
            <p>¡Gracias por hacer tu pedido! Tu pedido con ID #{{ $pedido->id }} se ha realizado con éxito.</p>

            <h3>Productos:</h3>
            <ul>
                @foreach($productos as $producto)
                <li>
                    <img src="{{ asset('storage/' . $producto['imagen']) }}" alt="{{ $producto['nombre'] }}" style="max-width: 60px; margin-right: 10px; vertical-align: middle;">
                    {{ $producto['nombre'] }} - Precio: ${{ $producto['precio'] }} - Cantidad: {{ $producto['cantidad'] }}
                </li>
                @endforeach
            </ul>

            <h3>Dirección de Envío:</h3>
            <p>
                {{ $pedido->direccion->recipient_name }}<br>
                {{ $pedido->direccion->calle }}, {{ $pedido->direccion->ciudad }}, {{ $pedido->direccion->estado }}, {{ $pedido->direccion->codigo_postal }}
            </p>

            <p>Total: ${{ $total }}</p>

            <p>Estamos procesando tu pedido y te informaremos una vez esté listo para envío.</p>
            @if(Auth::user()->role === 'admin')
            <a href="#" onclick="history.back();" class="btn btn-dark">↩</a>
            <a href="{{ route('admin.orders') }}" class="btn btn-dark">Ver todos los pedidos</a>
            @else
            <a href="{{ route('pedidos.historial') }}" class="btn btn-dark">Ir a Historial de Pedidos</a>
            @endif
        </div>
    </div>
</main>
@endsection