@extends('layouts.app')

@section('content')
   
    <main class="container text-center mt-5">
        <div class="card offset-lg-4 col-lg-4 p-4 shadow mt-n4">
            <form id="login-form" method="post" style="margin-bottom: 10px;">
                <h2 class="text-center">Inicio de sesión</h2>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario:</label>
                    <input class="form-control" type="text" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark">Iniciar Sesión</button>
                </div>
            </form>

            <?php if (!empty($error_message)) : ?>
                <div class="text-center text-danger mt-3">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <hr>
            <div class="text-center">
                <a href="register" class="text-dark mx-1">Registrarse</a>
                <a href="/recuperar-contraseña" class="text-dark mx-1">Restablecer Contraseña</a>
            </div>
            <?php if (!empty($error_message)) : ?>
                <div class="text-center text-danger mt-3">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
@endsection
