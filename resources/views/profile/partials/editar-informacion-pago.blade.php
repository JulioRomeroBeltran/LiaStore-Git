@extends('layouts.app')

@section('content')

<main class="container mt-5">
    <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">
        <form id="editar-informacion-pago-form" method="post" action="{{ route('informacion-pago.actualizar', ['id' => $informacionPago->id]) }}" style="text-align: left">
            @csrf
            @method('PUT')

            <h2 class="text-center mb-4">Editar Información de Pago</h2>

            <div class="mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                <input class="form-control" type="text" id="numero_tarjeta" name="numero_tarjeta" value="{{ $informacionPago->numero_tarjeta }}" required>
            </div>

            <div class="mb-3">
                <label for="nombre_tarjeta" class="form-label">Nombre en la Tarjeta:</label>
                <input class="form-control" type="text" id="nombre_tarjeta" name="nombre_tarjeta" value="{{ $informacionPago->nombre_tarjeta }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                <input class="form-control" type="text" id="fecha_expiracion" name="fecha_expiracion" value="{{ $informacionPago->fecha_expiracion }}" required>
            </div>

            <div class="mb-3">
                <label for="codigo_seguridad" class="form-label">Código de Seguridad:</label>
                <input class="form-control" type="text" id="codigo_seguridad" name="codigo_seguridad" value="{{ $informacionPago->codigo_seguridad }}" required>
            </div>

            <div class="form-check mb-3" style="display: none;">
                <input class="form-check-input" type="checkbox" id="principal" name="principal" checked {{ $informacionPago->principal ? 'checked' : '' }}>
                <label class="form-check-label" for="principal">
                    Marcar como Información de Pago Principal
                </label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                <a href="{{ route('mostrar-informacion-pago') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</main>

@endsection