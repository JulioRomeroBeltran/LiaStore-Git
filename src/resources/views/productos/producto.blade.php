@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            @if ($producto->imagen)
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h2 style="font-size: 35px;">{{ $producto->nombre }}</h2>
            <h4 style="margin-top: 30px; font-size: 24px;">${{ $producto->precio }} MX</h4>
            <p>Impuestos incluidos</p>

            <form action="{{ route('cart.addToCart', $producto->id) }}" method="post">
                @csrf
                <div class="btn-group" role="group" aria-label="Tamaño">
                    {{-- Mostrar las tallas disponibles del producto --}}
                    @foreach ($producto->tallas as $talla)
                    <button type="button" class="btn btn-dark" style="padding: 1px 25px;">{{ $talla->nombre }}</button>
                    @endforeach
                </div>

                <p class="mt-3">Cantidad</p>

                <div class="input-group mt-3 border" style="max-width: 100px;">
                    <button class="btn btn-white border-0" type="button" onclick="decrementQuantity()" style="font-weight: bold;">-</button>
                    <input type="text" class="form-control border-0" name="quantity" id="quantityInput" value="1" min="1" max="20" style="font-weight: bold;">
                    <button class="btn btn-white border-0" type="button" onclick="incrementQuantity()" style="font-weight: bold;">+</button>
                </div>

                <!-- Hidden fields for product ID and quantity -->
                <input type="hidden" name="product_id" value="{{ $producto->id }}">
                <input type="hidden" name="quantity" id="hiddenQuantityInput" value="1">

                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-white" style="font-size: 16px; border: 2px solid black;">Agregar al carrito</button>
                </div>
            </form>

            <div class="d-grid gap-2 mt-3">
                <button type="button" class="btn btn-dark" style="font-size: 16px;">Pagar pedido</button>
            </div>

            <br><br>
            <!-- Espacio para mostrar el ID del producto -->
            <p>ID del producto: {{ $producto->id }}</p>

            <!-- Accordion -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="dimensionsHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#dimensionsCollapse" aria-expanded="true" aria-controls="dimensionsCollapse">
                            Descripcion
                        </button>
                    </h2>
                    <div id="dimensionsCollapse" class="accordion-collapse collapse" aria-labelledby="dimensionsHeading" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{ $producto->descripcion }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenido anterior ... -->

<div class="container mt-5">
    <!-- Sección "Los más vendidos" -->
    <h2>Los más vendidos</h2>
    <div class="row">
        <!-- Loop through other products -->
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
    <div class="text-center mt-4">
        <a href="{{ route('product.catalogo') }}" class="btn btn-dark" style="width: 300px; margin-bottom:150px">Ver todo</a>
    </div>
    <style>
        .accordion-button {
            background-color: transparent !important;
            color: #000 !important;
            /* Set the desired text color */
        }

        .accordion-button:not(.collapsed) {
            background-color: transparent !important;
        }
    </style>
</div>
<script>
    // JavaScript functions to handle quantity changes
    function incrementQuantity() {
        console.log("Incrementing quantity...");
        let quantityInput = document.getElementById('quantityInput');
        let hiddenQuantityInput = document.getElementById('hiddenQuantityInput');
        let newQuantity = Math.min(parseInt(quantityInput.value) + 1, 20); // Limit to max 20
        console.log("New Quantity:", newQuantity);
        quantityInput.value = newQuantity;
        hiddenQuantityInput.value = newQuantity; // Update hidden input
    }

    function decrementQuantity() {
        let quantityInput = document.getElementById('quantityInput');
        let hiddenQuantityInput = document.getElementById('hiddenQuantityInput');
        let newQuantity = Math.max(parseInt(quantityInput.value) - 1, 1); // Limit to min 1
        quantityInput.value = newQuantity;
        hiddenQuantityInput.value = newQuantity; // Update hidden input
    }
</script>
@endsection