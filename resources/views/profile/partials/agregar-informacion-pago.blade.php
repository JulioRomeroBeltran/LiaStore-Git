@extends('layouts.app')

@section('content')

<main class="container mt-5">
    <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">

    @if($informacionPago && $informacionPago->count() > 0)
        <h2 class="text-center mb-4">Tu Información de Pago</h2>
        <div class="list-group">
            @foreach($informacionPago as $infoPago)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    Número de Tarjeta: {{ $infoPago->numero_tarjeta }}<br>
                    Nombre en la Tarjeta: {{ $infoPago->nombre_tarjeta }}<br>
                    Fecha de Expiración: {{ $infoPago->fecha_expiracion }}<br>
                    Código de Seguridad: {{ $infoPago->codigo_seguridad }}<br>
                    @if($infoPago->usuarioInformacionPago && $infoPago->usuarioInformacionPago->principal)
                        <span class="badge bg-dark">Principal</span>
                    @endif
                </div>
                <div class="d-flex">
                    <form method="POST" action="{{ route('informacion-pago.marcarPrincipal', ['id' => $infoPago->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">✓</button>
                    </form>
                    <div class="d-flex">
                        <form method="POST" action="{{ route('informacion-pago.destroy', ['id' => $infoPago->id]) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta información de pago?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                        </form>
                        <a href="{{ route('informacion-pago.editar', ['id' => $infoPago->id]) }}" class="btn btn-dark btn-sm me-2">Editar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#informacionPagoModal">Nueva Información de Pago</button>
        @else
        <form id="informacion-pago-form" method="post" action="{{ route('informacion-pago.store') }}" style="margin-bottom: 10px; text-align: left;">
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

        @if (session('success'))
        <div class="text-center text-success mt-3">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="text-center text-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <hr>
        <div class="text-center">
            {{-- Enlaces adicionales si los necesitas --}}
        </div>
    </div>
</main>
<div class="modal fade" id="informacionPagoModal" tabindex="-1" aria-labelledby="informacionPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informacionPagoModalLabel">Ingresar Información de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="informacion-pago-form-modal" method="post" action="{{ route('informacion-pago.store') }}" style="text-align: left;">
                    @csrf

                    <h2 class="text-center mb-4">Ingresar Información de Pago</h2>

                    <div class="mb-3">
                        <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                        <input class="form-control" type="text" id="numero_tarjeta_modal" name="numero_tarjeta" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_tarjeta" class="form-label">Nombre en la Tarjeta:</label>
                        <input class="form-control" type="text" id="nombre_tarjeta_modal" name="nombre_tarjeta" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                        <input class="form-control" type="text" id="fecha_expiracion_modal" name="fecha_expiracion" required>
                    </div>

                    <div class="mb-3">
                        <label for="codigo_seguridad" class="form-label">Código de Seguridad:</label>
                        <input class="form-control" type="text" id="codigo_seguridad_modal" name="codigo_seguridad" required>
                    </div>

                    <div class="form-check mb-3" style="display: none;">
                        <input class="form-check-input" type="checkbox" id="principal_modal" name="principal" checked>
                        <label class="form-check-label" for="principal_modal">
                            Marcar como Información de Pago Principal
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Guardar Información de Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection