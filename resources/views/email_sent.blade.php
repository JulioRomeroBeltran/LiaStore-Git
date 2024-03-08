@extends('layouts.app')

@section('content')
<main style="margin-bottom:430px;">
    <div class="container mt-5 mb-5">
        <div class="card offset-lg-2 col-lg-8 p-3 shadow">
            <form id="reset-proceso" style="margin-bottom: 50px;">
                <h2 class="text-center" style="margin-top: 55px;">Te acabamos de enviar un correo!</h2>
                <div class="container text-center">
                    <div class="d-grid gap-2 mt-5">
                        <a href="/" class="btn btn-dark btn-lg">Volver a la página de inicio</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
