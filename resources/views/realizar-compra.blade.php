@extends('layouts.app')

@section('content')
<div class="container padding-bottom">
    <div class="row">
        <div class="col-md-6">
            <div class="panel left-panel">
                <h2>Lia Store Tienda Online</h2>
                <h5>Carrito> <span>Informacion</span></h5>
                <div>
                    <p>Pago Express</p>
                    <div>
                        <button class="btn btn-link"><img src="Paypal.png" style="border-radius: 0;"></button>
                        <button class="btn btn-link"> <img src="apple.png" style="border-radius: 0;"></button>
                    </div>
                </div>
                <hr class="solid">

                <form>
                    <h3>Contacto</h3>
                    <input type="text" class="form-control mb-3" placeholder="Correo Electrónico">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="novedades" name="novedades">
                        <label class="form-check-label" for="novedades">Enviarme novedades y ofertas por correo electrónico</label>
                    </div>
                    <hr class="solid">

                    @if($informacionPago && $informacionPago->count() > 0)
                    <h3>Información de Pago</h3>
                    <div class="list-group mb-3">
                        @foreach($informacionPago as $infoPago)
                        <div class="info-pago-container border rounded mb-2 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Número de Tarjeta: {{ $infoPago->numero_tarjeta }}<br>
                                    Nombre en la Tarjeta: {{ $infoPago->nombre_tarjeta }}<br>
                                    @if($infoPago->usuarioInformacionPago && $infoPago->usuarioInformacionPago->principal)
                                    <span class="badge bg-dark">Principal</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <form id="informacion-pago-form" method="post" action="{{ route('cart.storePaymentInfo') }}" style="margin-bottom: 10px; text-align: left;">
                        @csrf

                        <h2 class="text-center mb-4">Ingresar Información de Pago</h2>

                        <div class="mb-3">
                            <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                            <input class="form-control" type="text" id="numero_tarjeta" name="numero_tarjeta" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre_tarjeta" class="form-label">Nombre en la Tarjeta:</label>
                            <input class="form-control" type="text" id="nombre_tarjeta" name="nombre_tarjeta" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                            <input class="form-control" type="text" id="fecha_expiracion" name="fecha_expiracion" required>
                        </div>

                        <div class="mb-3">
                            <label for="codigo_seguridad" class="form-label">Código de Seguridad:</label>
                            <input class="form-control" type="text" id="codigo_seguridad" name="codigo_seguridad" required>
                        </div>

                        <div class="form-check mb-3" style="display: none;">
                            <input class="form-check-input" type="checkbox" id="principal" name="principal" checked>
                            <label class="form-check-label" for="principal">
                                Marcar como Información de Pago Principal
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">Guardar Información de Pago</button>
                        </div>
                    </form>
                    @endif

                    @if($direcciones && $direcciones->count() > 0)
                    <h3 class="mt-3">Dirección de Envío</h3>
                    <div class="list-group mb-3">
                        @foreach($direcciones as $direccion)
                        <div class="info-direccion-container border rounded mb-2 p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    {{ $direccion->recipient_name }} - {{ $direccion->calle }}, {{ $direccion->ciudad }}, {{ $direccion->estado }}, {{ $direccion->codigo_postal }}
                                    @if($direccion->usuarioDireccion && $direccion->usuarioDireccion->active)
                                    <span class="badge bg-dark">Principal</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <h3 class="text-center mb-4">Ingrese Dirección de Envío</h3>
                    <form id="address-form" method="post" action="{{ route('cart.storeAddress') }}" style="margin-bottom: 10px; text-align: left;">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Nombre del destinatario:</label>
                            <input class="form-control" type="text" id="recipient_name" name="recipient_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="recipient_phone" class="form-label">Teléfono del destinatario:</label>
                            <input class="form-control" type="tel" id="recipient_phone" name="recipient_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="street" class="form-label">Calle:</label>
                            <input class="form-control" type="text" id="street" name="street" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Ciudad:</label>
                            <input class="form-control" type="text" id="city" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">Estado:</label>
                            <input class="form-control" type="text" id="state" name="state" required>
                        </div>
                        <div class="mb-3">
                            <label for="zip" class="form-label">Código Postal:</label>
                            <input class="form-control" type="text" id="zip" name="zip" required>
                        </div>
                        <div class="mb-3">
                            <label for="additional_info" class="form-label">Información adicional:</label>
                            <textarea class="form-control" id="additional_info" name="additional_info" rows="3"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">Guardar Dirección</button>
                        </div>
                    </form>
                    @endif

                    <div class="end-form">
                        <a href="{{ route('cart.showCart') }}" id="volverEnlace" class="btn btn-secondary">Volver a Carrito</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6" style="background-color: rgba(242, 242, 242, 0.9); min-height: 800px;">
            <div class="panel right-panel ">
                <div class="summary ">
                    <h3 class="mb-4 ">Resumen del Carrito</h3>
                    @if($cartItems && $cartItems->count() > 0)
                    <form action="{{ route('procesar_pedido') }}" method="post">
                        @csrf
                        <ul class="list-group">
                            @foreach($cartItems as $cartItem)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $cartItem->product->imagen) }}" alt="{{ $cartItem->product->nombre }}" class="me-2" style="max-width: 60px;">
                                    <div>
                                        <h6 class="mb-0">{{ $cartItem->product->nombre }}</h6>
                                        <small class="text-muted">Precio: ${{ $cartItem->product->precio }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-dark rounded-pill">{{ $cartItem->quantity }}</span>

                                <!-- Agrega campos ocultos para cada producto con un índice único -->
                                <input type="hidden" name="productos[{{ $cartItem->product->id }}][id]" value="{{ $cartItem->product->id }}">
                                <input type="hidden" name="productos[{{ $cartItem->product->id }}][nombre]" value="{{ $cartItem->product->nombre }}">
                                <input type="hidden" name="productos[{{ $cartItem->product->id }}][precio]" value="{{ $cartItem->product->precio }}">
                                <input type="hidden" name="productos[{{ $cartItem->product->id }}][cantidad]" value="{{ $cartItem->quantity }}">
                            </li>
                            @endforeach
                        </ul>

                        <style>
                            .seleccionado {
                                background-color: #343a40;
                                color: #fff;
                            }
                        </style>

                        <div class="total text-end" style="margin-right:5px; margin-top: 5px;">
                            <h3 class="text-start" style="margin-left:10px;">Tipos de envio</h3>
                            <input type="hidden" name="direccion_id" value="{{ $direccion->id }}">
                            <div class="container mt-3 text-center">
                                <div class="row">
                                    @foreach($tiposEnvio as $tipo)
                                    <div class="col-md-4 mb-3 text-center">
                                        <button type="button" class="btn btn-light seccion" data-id="{{ $tipo->id }}" onclick="seleccionarSeccion(this)">
                                            <div class="circulo"></div>
                                            <p class="card-text">{{ $tipo->nombre }} - {{ $tipo->costo }} MXN</p>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="total text-end" style="margin-right:5px; margin-top: 5px;">
                                <h5>Costo de Envío:</h5>
                                <p id="costoEnvio">${{ $costoEnvio }}</p>
                            </div>

                            <div class="total text-end" style="margin-right:5px; margin-top: 5px;">
                                <h5>Costo de Productos:</h5>
                                <p id="costoProductos">${{ $totalProductos }}</p>
                            </div>

                            <div class="total text-end" style="margin-right:5px; margin-top: 5px;">
                                <h5>Total:</h5>
                                <p id="total">${{ $total }}</p>
                            </div>

                            <input type="hidden" name="tipo_envio_seleccionado" id="tipo_envio_seleccionado" value="{{ old('tipo_envio_seleccionado', $costoEnvio) }}">
                            <input type="hidden" name="costo_envio_seleccionado" id="costo_envio_seleccionado" value="{{ old('costo_envio_seleccionado', $costoEnvio) }}">

                            <div class="d-flex justify-content-end">
                                <input type="submit" class="enviar-btn btn btn-dark" value="Pagar">
                            </div>

                        </div>
                    </form>
                    @else
                    <p>No hay productos en el carrito.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function seleccionarSeccion(elemento) {
        var elementos = document.querySelectorAll('.seccion');
        elementos.forEach(function(el) {
            el.classList.remove('seleccionado');
        });

        elemento.classList.add('seleccionado');

        var tipoEnvioSeleccionadoElement = document.getElementById('tipo_envio_seleccionado');
        if (tipoEnvioSeleccionadoElement) {
            tipoEnvioSeleccionadoElement.value = elemento.getAttribute('data-id');
        }

        var costoEnvioText = elemento.querySelector('.card-text').innerText;

        var match = costoEnvioText.match(/\d+\.\d+/);
        var costoEnvio = match ? parseFloat(match[0]) : 0;

        var costoEnvioElement = document.getElementById('costoEnvio');
        if (costoEnvioElement) {
            costoEnvioElement.innerText = '$' + costoEnvio.toFixed(2);
        }

        var costoEnvioSeleccionadoElement = document.getElementById('costo_envio_seleccionado');
        if (costoEnvioSeleccionadoElement) {
            costoEnvioSeleccionadoElement.value = costoEnvio;
        }

        recalcularTotal();
    }

    function recalcularTotal() {
        var costoProductos = parseFloat(document.getElementById('costoProductos').innerText.match(/\d+/)[0]);

        var costoEnvio = parseFloat(document.getElementById('costo_envio_seleccionado').value);

        var nuevoTotal = costoProductos + costoEnvio;

        document.getElementById('total').innerText = '$' + nuevoTotal;
    }
</script>
@endsection