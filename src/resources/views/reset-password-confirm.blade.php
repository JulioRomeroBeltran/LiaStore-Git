{{-- resources/views/reset-password-confirm.blade.php --}}
@extends('layouts.app')

@section('content')
<main style="margin-bottom: 300px;">
    <div class="container mt-5 mb-5">
        <div class="card offset-lg-4 col-lg-4 p-4 shadow-sm">
            @if(session('status') == 'password-updated')
                <div class="alert alert-success mb-3" role="alert">
                    Contraseña actualizada con éxito. Puedes iniciar sesión con tu nueva contraseña.
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-dark">Iniciar sesión</a>
                </div>
            @else
                <form id="change-password-form" method="post" action="{{ route('password.change') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    @if (isset($user))
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    @endif
                    <h2 class="text-center">Cambiar Contraseña</h2>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nueva Contraseña" required>
                        <label for="new_password">Nueva Contraseña</label>
                        @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                        <label for="confirm_password">Confirmar Contraseña</label>
                        @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Cambiar Contraseña</button>
                    </div>
                </form>

                @if (!empty(session('mensaje')))
                <div class="mt-3 alert alert-danger" role="alert">
                    {{ session('mensaje') }}
                </div>
                @endif
            @endif
        </div>
    </div>
</main>
@endsection
