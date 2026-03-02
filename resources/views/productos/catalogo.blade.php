@extends('layouts.app')

@section('content')
<style>
    #filterToggleBtn {
        border: 1px solid #ced4da;
        background-color: #fff;
        color: #495057;
    }
    #filterToggleBtn:hover,
    #filterToggleBtn:focus,
    #filterToggleBtn:active {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        border-color: #ced4da !important;
        box-shadow: none !important;
    }
</style>

<div class="container-fluid px-3">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <button id="filterToggleBtn" class="btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
            Filtros ▼
        </button>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <label for="sorting" class="form-label mb-0 text-nowrap" style="font-size: smaller;">Ordenar por:</label>
            <select name="sorting" id="sorting" class="form-select border-0" style="width: auto;">
                <option value="name_asc" {{ request('sorting') === 'name_asc' ? 'selected' : '' }}>Nombre (A a la Z)</option>
                <option value="name_desc" {{ request('sorting') === 'name_desc' ? 'selected' : '' }}>Nombre (Z a la A)</option>
                <option value="price_asc" {{ request('sorting') === 'price_asc' ? 'selected' : '' }}>Precio (menor a mayor)</option>
                <option value="price_desc" {{ request('sorting') === 'price_desc' ? 'selected' : '' }}>Precio (mayor a menor)</option>
            </select>
        </div>
    </div>
</div>

<div class="container-fluid px-3">
    <div class="row">
        <div class="col-md-2 col-12">
            <div class="collapse d-md-block" id="filterCollapse">
            <div class="card shadow" id="filterBar">
                <div class="card-body">
                    <form action="{{ route('product.catalogo') }}" method="GET">
                        <div class="mb-3">
                            <label for="availability" class="form-label">Disponibilidad:</label>
                            <select name="availability" id="availability" class="form-select" onchange="this.form.submit()">
                                <option value="">Todo</option>
                                <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>No disponible</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color:</label>
                            <div class="d-flex flex-wrap">
                                @foreach($colores as $color)
                                @php
                                $isChecked = in_array($color->id, request('color', []));
                                @endphp
                                <label for="color_{{ $color->id }}" style="cursor: pointer; margin-right: 10px;">
                                    <input type="checkbox" name="color[]" id="color_{{ $color->id }}" value="{{ $color->id }}" style="display: none;">
                                    <span class="badge rounded-pill color-badge" style="background-color: #{{ $color->codigo }}; border: 1px solid #c7c7c7; filter: brightness({{ $isChecked ? '80%' : '100%' }});" onclick="toggleColor(this)">&nbsp;</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="style" class="form-label">Estilo:</label>
                            <select name="style" id="style" class="form-select" onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach($estilos as $estilo)
                                <option value="{{ $estilo->id }}" {{ $estilo->id == request('style') ? 'selected' : '' }}>
                                    {{ $estilo->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo de prenda:</label>
                            <select name="type" id="type" class="form-select" onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach($tipos_prenda as $tipo)
                                <option value="{{ $tipo->id }}" {{ $tipo->id == request('type') ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            @if($hasFilters)
                            <button class="btn btn-danger me-2" type="button" onclick="window.location.href='/catalogo'">Borrar filtros</button>
                            @endif
                            <button class="btn btn-dark" type="submit">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                @forelse ($filteredProducts as $product)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('product.show', ['productId' => $product->id]) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow">
                            @if ($product->imagen)
                            <img src="{{ asset('storage/' . $product->imagen) }}" alt="{{ $product->nombre }}" class="card-img-top">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->nombre }}</h5>
                                <p class="card-text">${{ number_format($product->precio, 2) }} MXN</p>
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
    </div>
</div>
</div>


<script>
    window.addEventListener('scroll', function() {
        var filterBar = document.getElementById('filterBar');
        if (window.scrollY > 150) {
            filterBar.style.top = (window.scrollY - 140) + 'px';
        } else {
            filterBar.style.top = '0';
        }
    });

    function toggleColor(colorSpan) {
        colorSpan.style.filter = colorSpan.style.filter === 'brightness(80%)' ? 'brightness(100%)' : 'brightness(80%)';
    }
</script>


@endsection