@extends('layouts.app')

@section('content')

<main class="container mt-5">
    <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">

        @if($direcciones && $direcciones->count() > 0)
        <h2 class="text-center mb-4">Tus Direcciones</h2>
        <div class="list-group">
            @foreach($direcciones as $direccion)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    {{ $direccion->recipient_name }} - {{ $direccion->calle }}, {{ $direccion->ciudad }}, {{ $direccion->estado }}, {{ $direccion->codigo_postal }}
                    @if($direccion->usuarioDireccion && $direccion->usuarioDireccion->active)
                    <span class="badge bg-dark">Principal</span>
                    @endif
                </div>
                <div class="d-flex">
                    <form method="POST" action="{{ route('direcciones.marcarPrincipal', ['id' => $direccion->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">✓</button>
                    </form>
                    <div class="d-flex">
                    <form method="POST" action="{{ route('direcciones.destroy', ['id' => $direccion->id]) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta dirección?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                        </form>
                        <a href="{{ route('direcciones.editar', ['id' => $direccion->id]) }}" class="btn btn-dark btn-sm me-2">Editar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr>
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#direccionModal">Nueva Dirección</button>
        @else
        <form id="address-form" method="post" action="{{ route('direcciones.store') }}" style="margin-bottom: 10px; text-align: left;">
            @csrf

            <h2 class="text-center mb-4">Ingresar Dirección</h2>

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
<div class="modal fade" id="direccionModal" tabindex="-1" aria-labelledby="direccionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="direccionModalLabel">Ingresar Dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Replicamos el formulario aquí -->
                <form id="address-form-modal" method="post" action="{{ route('direcciones.store') }}" style="text-align: left;">
                    @csrf

                    <h2 class="text-center mb-4">Ingresar Dirección</h2>

                    <div class="mb-3">
                        <label for="recipient_name" class="form-label">Nombre del destinatario:</label>
                        <input class="form-control" type="text" id="recipient_name_modal" name="recipient_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_phone" class="form-label">Teléfono del destinatario:</label>
                        <input class="form-control" type="tel" id="recipient_phone_modal" name="recipient_phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="street" class="form-label">Calle:</label>
                        <input class="form-control" type="text" id="street_modal" name="street" required>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Ciudad:</label>
                        <input class="form-control" type="text" id="city_modal" name="city" required>
                    </div>

                    <div class="mb-3">
                        <label for="state" class="form-label">Estado:</label>
                        <input class="form-control" type="text" id="state_modal" name="state" required>
                    </div>

                    <div class="mb-3">
                        <label for="zip" class="form-label">Código Postal:</label>
                        <input class="form-control" type="text" id="zip_modal" name="zip" required>
                    </div>

                    <div class="mb-3">
                        <label for="additional_info" class="form-label">Información adicional:</label>
                        <textarea class="form-control" id="additional_info_modal" name="additional_info" rows="3"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Guardar Dirección</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
