@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Productos</h2>
    <div class="card p-4 shadow">
        <form action="{{ route('product.catalogo') }}" method="GET">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="availability" class="form-label">Disponibilidad:</label>
                    <select name="availability" id="availability" class="form-select">
                        <option value="all">Todo</option>
                        <option value="available">Disponible</option>
                        <option value="unavailable">No disponible</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Precio:</label>
                    <select name="price" id="price" class="form-select">
                        <option value="all">Todo</option>
                        <option value="low_to_high">Menor a mayor</option>
                        <option value="high_to_low">Mayor a menor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="alphabetical" class="form-label">Alfabetico:</label>
                    <select name="alphabetical" id="alphabetical" class="form-select">
                        <option value="all">Todo</option>
                        <option value="a_to_z">A a la Z</option>
                        <option value="z_to_a">Z a la A</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nombre del producto">
                </div>
            </div>

            <div class="text-end">
                <button class="btn btn-dark btn-submit" type="submit">Filtrar</button>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        @forelse ($filteredProducts as $product)
        <div class="col-md-4 mb-4 shadow">
            <a href="{{ route('product.show', ['productId' => $product->id]) }}" class="text-decoration-none text-dark">
                <div class="card h-100">
                    @if ($product->imagen)
                    <img src="{{ asset('storage/' . $product->imagen) }}" alt="{{ $product->nombre }}" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->nombre }}</h5>
                        <p class="card-text">Precio: {{ $product->precio }}</p>
                        {{-- Add more details as needed --}}
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col">
            <p class="text-center">No products found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection