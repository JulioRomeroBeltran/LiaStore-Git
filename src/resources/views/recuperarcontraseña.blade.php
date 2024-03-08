@extends('layouts.app')

@section('content')
</head>

<body>

    <div class="container mt-5 mb-5">
        <div class="card offset-lg-2 col-lg-8 p-3 shadow">
            <form id="reset-form" action="reset_password.php" method="post" style="margin-bottom: 50px;">
                <h2 class="text-center">Restablecer tu contraseña</h2>
                <h2 class="text-center" style="margin-top: 55px;">Te enviaremos un correo electrónico para restablecer tu contraseña</h2>
                <div class="mb-4">
                    <label for="email" class="form-label" style="margin-top: 25px;">Correo Electrónico:</label>
                    <input class="form-control" type="email" id="email" name="email" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark btn-lg">Enviar</button>
                </div>
            </form>
        </div>
    </div>

</body>
@endsection