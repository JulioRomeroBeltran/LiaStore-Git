@extends('layouts.app')

@section('content')
<main style="margin-bottom: 255px;">
    <div class="container mt-5 mb-5">
        <div class="card offset-lg-4 col-lg-4 p-4 shadow">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h2 class="text-center">{{ __('Registrarse') }}</h2>

                <div class="row mb-3">
                    <label for="name" class="">{{ __('Nombre:') }}</label>
                    <div class="col-md-12"> 
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="">{{ __('Correo Electrónico:') }}</label>
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="">{{ __('Contraseña:') }}</label>
                    <div class="col-md-12"> 
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="">{{ __('Confirmar contraseña:') }}</label>
                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-12 text-center mt-2">
                        <button type="submit" style="width: 100%;" class="btn btn-dark">
                            {{ __('Registrarse') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</main>
@endsection
