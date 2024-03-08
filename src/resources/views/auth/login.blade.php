@extends('layouts.app')

@section('content')

<main style="margin-bottom: 255px;">
    <div class="container mt-5 mb-5">
        <div class="card offset-lg-4 col-lg-4 p-4 shadow">
            <form id="login-form" method="post" action="{{ route('login') }}" style="margin-bottom: 10px;">
                @csrf <!-- Add this line to include the CSRF token -->
                <h2 class="text-center">Inicio de sesión</h2>
                <div class="mb-3">
                    
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input class="form-control" type="text" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark">Iniciar Sesión</button>
                </div>
            </form>

            @if ($errors->any())
            <div class="text-center text-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div class="text-center text-danger mt-3">
                {{ session('error') }}
            </div>
            @endif

            <hr>
            <div class="text-center">
                <a href="{{ route('register') }}" class="text-dark mx-1">Registrarse</a>
                <a href="{{ route('password.reset') }}" class="text-dark mx-1">Restablecer Contraseña</a>
            </div>
        </div>
    </div>
</main>
@endsection
