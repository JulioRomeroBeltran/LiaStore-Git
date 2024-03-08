<!-- resources\views\profile\partials\eliminar-direccion.blade.php -->

@extends('layouts.app')

@section('content')

<main class="container mt-5">
    <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">
        <h2 class="text-center mb-4">Eliminar Dirección</h2>
        <p>¿Estás seguro de que deseas eliminar esta dirección?</p>

        <form id="eliminar-direccion-form" method="post" action="{{ route('direcciones.destroy', ['id' => $direccion->id]) }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-dark" onclick="cancelarEliminacion()">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar Dirección</button>
        </form>
    </div>
</main>

<script>
    function cancelarEliminacion() {
        // Redirige a la página de direcciones sin enviar el formulario
        window.location.href = "{{ route('direcciones.index') }}";
    }
</script>

@endsection