@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center mb-4">Asignar Rol de Administrador</h2>

        <form method="post" action="{{ route('asignar-admin') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico del Usuario:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">Asignar Rol de Administrador</button> <a href="#" onclick="history.back();" class="btn btn-dark">↩</a>

            </div>
        </form>

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
    </div>
</div>
@endsection