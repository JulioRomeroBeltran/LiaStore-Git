@extends('layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Estilos para la barra lateral */
.sidebar {
    height: 80%; /* Cambio de 100% a 80% para reducir la altura */
    max-height: 550px; /* También puedes establecer una altura máxima */
    width: 0; /* barra lateral oculta inicialmente */
    position: fixed;
    z-index: 1000; /* asegura que la sidebar esté sobre otros elementos */
    top: 15%; /* Centra verticalmente cambiando el top a 10% */
    left: 0;
    background-color: #f8f9fa; /* color de fondo */
    overflow-x: hidden; /* oculta contenido desbordado en el eje X */
    transition: 0.5s; /* animación suave al abrir/cerrar */
    padding-top: 20px; /* ajuste de padding superior */
    border-right: 1px solid #ccc; /* añade un borde para mejor visualización */
}

/* Estilo para abrir la barra lateral */
.open-btn {
    cursor: pointer;
    position: fixed;
    top: 15%;
    left: 0;
    font-size: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    z-index: 1001; /* asegura que el botón esté sobre la barra lateral */
    transition: left 0.5s; /* animación para que el botón se mueva con la barra */
}

/* Estilo para cerrar la barra lateral */
.close-btn {
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    color: #aaa;
}
</style>

<div id="mySidebar" class="sidebar">
    <button class="open-btn" onclick="toggleSidebar()">
        <i class="bi bi-arrow-right"></i> <!-- Icono de flecha hacia la derecha -->
    </button>
    <a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>
    <h2 class="text-center">Filtros</h2>
    <form action="{{ route('product.catalogo') }}" method="GET">
        <!-- Filtros de productos aquí -->
        <div class="mb-3">
            <label for="sorting" class="form-label">Ordenar por:</label>
            <select name="sorting" id="sorting" class="form-select">
                <option value="name_asc" selected>Nombre (A a la Z)</option>
                <option value="name_desc">Nombre (Z a la A)</option>
                <option value="price_asc">Precio (menor a mayor)</option>
                <option value="price_desc">Precio (mayor a menor)</option>
            </select>
        </div>
        <!-- Repetir para otros filtros -->
        <div class="mb-3">
            <label for="availability" class="form-label">Disponibilidad:</label>
            <select name="availability" id="availability" class="form-select">
                <option value="">Todo</option>
                <option value="available">Disponible</option>
                <option value="unavailable">No disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <select name="color" id="color" class="form-select">
                <option value="">Todos</option>
                @foreach($colores as $color)
                <option value="{{ $color->id }}">
                    {{ $color->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="style" class="form-label">Estilo:</label>
            <select name="style" id="style" class="form-select">
                <option value="">Todos</option>
                @foreach($estilos as $estilo)
                <option value="{{ $estilo->id }}">
                    {{ $estilo->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Tipo de prenda:</label>
            <select name="type" id="type" class="form-select">
                <option value="">Todos</option>
                @foreach($tipos_prenda as $tipo)
                <option value="{{ $tipo->id }}">
                    {{ $tipo->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-dark" type="submit">Filtrar</button>
        <button class="btn btn-danger" type="button" onclick="window.location.href='/catalogo'">Borrar filtros</button>
    </form>
</div>

<div class="container mt-5">
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
                        <p class="card-text">{{ $product->precio }}</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p class="text-center">No se encontraron productos.</p>
        @endforelse
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("mySidebar");
        var openBtn = document.querySelector(".open-btn");

        if (sidebar.style.width === "250px") {
            sidebar.style.width = "0";
            openBtn.style.left = "10px"; // Mueve el botón a la posición original
        } else {
            sidebar.style.width = "250px";
            openBtn.style.left = "-40px"; // Oculta el botón
        }
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
    }
</script>
@endsection