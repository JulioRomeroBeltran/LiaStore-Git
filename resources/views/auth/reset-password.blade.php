@extends('layouts.app')

@section('content')

<body>
    <div class="container mt-5 mb-5">
        <div class="card offset-lg-2 col-lg-8 p-3 shadow">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form id="reset-form" action="/check-email" method="post" style="margin-bottom: 50px;">
                @csrf
                <h2 class="text-center">Restablecer tu contraseña</h2>
                <h2 class="text-center" style="margin-top: 55px;">Te enviaremos un correo electrónico para restablecer tu contraseña</h2>
                <div class="mb-4">
                    <label for="email" class="form-label" style="margin-top: 25px;">Correo Electrónico:</label>
                    <input class="form-control" type="email" id="email" name="email" required>
                </div>
                @if ($errors->any())
                <div class="text-center text-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark btn-lg">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection