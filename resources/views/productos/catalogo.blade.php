@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Productos</h2>
    <div class="card p-4 shadow">
        <form action="{{ route('product.catalogo') }}" method="GET">
            <div class="row mb-3 justify-content-end align-items-center">
                <div class="col-md-auto pe-0">
                    <label for="price" class="form-label mt-2" style="font-size: smaller;">Ordenar por:</label>
                </div>
                <div class="col-md-3">
                    <select name="sorting" id="sorting" class="form-select border-0">
                        <option value="">Por defecto</option>
                        <option value="price_asc" {{ request('sorting') === 'price_asc' ? 'selected' : '' }}>Precio (menor a mayor)</option>
                        <option value="price_desc" {{ request('sorting') === 'price_desc' ? 'selected' : '' }}>Precio (mayor a menor)</option>
                        <option value="name_asc" {{ request('sorting') === 'name_asc' ? 'selected' : '' }}>Nombre (A a la Z)</option>
                        <option value="name_desc" {{ request('sorting') === 'name_desc' ? 'selected' : '' }}>Nombre (Z a la A)</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="availability" class="form-label">Disponibilidad:</label>
                    <select name="availability" id="availability" class="form-select">
                        <option value="">Todo</option>
                        <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>No disponible</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="color" class="form-label">Color:</label>
                    <select name="color" id="color" class="form-select">
                        <option value="">Todos</option>
                        @foreach($colores as $color)
                        <option value="{{ $color->id }}" {{ $color->id == request('color') ? 'selected' : '' }}>
                            {{ $color->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="style" class="form-label">Estilo:</label>
                    <select name="style" id="style" class="form-select">
                        <option value="">Todos</option>
                        @foreach($estilos as $estilo)
                        <option value="{{ $estilo->id }}" {{ $estilo->id == request('style') ? 'selected' : '' }}>
                            {{ $estilo->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="type" class="form-label">Tipo de prenda:</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">Todos</option>
                        @foreach($tipos_prenda as $tipo)
                        <option value="{{ $tipo->id }}" {{ $tipo->id == request('type') ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end">
                    <button class="btn btn-dark btn-submit" type="submit">Filtrar</button>
                </div>

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
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col">
            <p class="text-center">No se encontraron productos.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection