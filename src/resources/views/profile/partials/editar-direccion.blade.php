<!-- resources\views\profile\editar-direccion.blade.php -->

@extends('layouts.app')

@section('content')

<main class="container mt-5">
    <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">
        <form id="editar-direccion-form" method="post" action="{{ route('direcciones.actualizar', ['id' => $direccion->id]) }}" style="text-align: left">
            @csrf
            @method('PUT')

            <h2 class="text-center mb-4">Editar Dirección</h2>

            <div class="mb-3">
                <label for="recipient_name_edit" class="form-label">Nombre del destinatario:</label>
                <input class="form-control" type="text" id="recipient_name_edit" name="recipient_name" value="{{ $direccion->recipient_name }}" required>
            </div>

            <div class="mb-3">
                <label for="recipient_phone" class="form-label">Teléfono del destinatario:</label>
                <input class="form-control" type="tel" id="recipient_phone" name="recipient_phone" value="{{ $direccion->recipient_phone }}" required>
            </div>

            <div class="mb-3">
                <label for="street" class="form-label">Calle:</label>
                <input class="form-control" type="text" id="street" name="street" value="{{ $direccion->calle }}" required>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">Ciudad:</label>
                <input class="form-control" type="text" id="city" name="city" value="{{ $direccion->ciudad }}" required>
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">Estado:</label>
                <input class="form-control" type="text" id="state" name="state" value="{{ $direccion->estado }}" required>
            </div>

            <div class="mb-3">
                <label for="zip" class="form-label">Código Postal:</label>
                <input class="form-control" type="text" id="zip" name="zip" value="{{ $direccion->codigo_postal }}"required>
            </div>

            <div class="mb-3">
                <label for="additional_info" class="form-label">Información adicional:</label>
                <textarea class="form-control" id="additional_info" name="additional_info" value="{{ $direccion->aditional_info }}" rows="3"></textarea>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                <a href="{{ route('mostrar-direcciones') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</main>

@endsection