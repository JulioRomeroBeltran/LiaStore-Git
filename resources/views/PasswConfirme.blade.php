<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>passwconfirme</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Liastore</title>
    @extends('layouts.app')

@section('content')
    
<main style="margin-bottom: 300px;">

    <div class="container mt-5 mb-5">
        <div class="card offset-lg-4 col-lg-4 p-4 shadow-sm">
            <form id="change-password-form" method="post">
                <h2 class="text-center">Cambiar Contraseña</h2>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nueva Contraseña" required>
                    <label for="new_password"></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                    <label for="confirm_password"></label>
                </div>
            
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark">Cambiar Contraseña</button>
                </div>
            </form>
            <?php if (!empty($mensaje)) { ?>
                <div class="mt-3 <?php echo ($mensaje === "Cambio de contraseña exitoso.") ? 'alert alert-success' : 'alert alert-danger'; ?>" role="alert">
                    <?php echo $mensaje; ?>
                </div>
                <?php if ($mensaje === "Cambio de contraseña exitoso.") { ?>
                    <div class="mt-3 text-center">
                        <a href="/liastore" class="btn btn-dark">Ir a Liastore</a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    
</main>
@endsection

