@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Carrito</h2>

    @if(session('success'))
    <div class="alert alert-success mt-3" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cartItems as $item)
            @if ($item->quantity > 0)
            <tr>
                <td>
                    @if (isset($item->product->imagen))
                    <img src="{{ asset('storage/' . $item->product->imagen) }}" alt="{{ $item->product->nombre }}" style="max-width: 50px; max-height: 50px;">
                    @endif
                </td>
                <td>{{ $item->product->nombre ?? 'N/A' }}</td>
                <td>${{ $item->product->precio ?? 'N/A' }}</td>
                <td>

                    <!-- Quantity input form -->
                    <form action="{{ route('cart.updateQuantity', ['productId' => $item->product_id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" required>
                        <button type="submit" class="btn btn-dark">Actualizar</button>
                    </form>


                </td>
                <td>${{ ($item->product->precio ?? 0) * ($item->quantity ?? 0) }}</td>
            </tr>
            @endif
            @empty
            <tr>
                <td colspan="5">No hay productos en el carrito.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if (count($cartItems) > 0)
    <div class="text-end">
        <h4>Total: ${{ $total }}</h4>
        <a href="{{ route('checkout') }}" class="btn btn-dark">Pagar</a>
    </div>
    @else
    <p>Tu carrito esta vacio.</p>
    @endif
</div>

<!-- Display more products -->
<div class="container mt-5">
    <h2>Más productos</h2>
    <div class="row">
        @foreach ($otherProducts as $otherProduct)
        <div class="col-md-3 mb-4">
            <a href="{{ route('product.show', $otherProduct->id) }}" style="text-decoration: none; color: inherit;">
                <div class="card">
                    @if ($otherProduct->imagen)
                    <img src="{{ asset('storage/' . $otherProduct->imagen) }}" class="card-img-top" alt="{{ $otherProduct->nombre }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $otherProduct->nombre }}</h5>
                        <p class="card-text">${{ $otherProduct->precio }} MX</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection