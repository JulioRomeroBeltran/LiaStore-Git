@extends('layouts.app')
@section('content')
    
<link rel="stylesheet" type="text/css" href="{{ asset('css/inicio.css') }}">

    <main>
        <div class="custom-container mt-4">
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title custom-card-title custom-text-center">Colecciones</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('product.show', ['productId' => 4]) }}">
                            <img src="tirantesrosa.jpg" alt="Imagen 1" class="custom-img">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('product.show', ['productId' => 8]) }}">
                            <img src="vestidowhite.jpg" alt="Imagen 2" class="custom-img">
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/catalogo" class="btn btn-dark">Ir a vestidos</a>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title custom-card-title custom-text-center">Todas las prendas son exclusivas, una vez se agotan ya no vuelven a salir</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('product.show', ['productId' => 3]) }}">
                            <img src="tirantesnegro.jpg" alt="Imagen 3" class="custom-img">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="card-text bg-light p-3">
                            <h6 class="text-dark custom-card-title">Vestido de tirantes</h6>
                            <p class="text-dark custom-card-text">Prenda exclusiva y limitada</p>
                            <a href="{{ route('product.show', ['productId' => 30]) }}" class="btn btn-dark btn-block">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/catalogo" class="btn btn-dark">Ver artículos</a>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title custom-card-title">Artículo 3</h5>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img src="Rack.png" alt="Imagen 1" class="custom-img">
                        <div class="text-center mt-2">
                            <img src="logo.png" alt="Logo">
                            <p class="font-weight-bold custom-card-text">Una Gran Variedad De Colores, con productos de la mejor calidad</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="Tiendafisica.png" alt="Imagen 2" class="custom-img">
                        <div class="text-center mt-2">
                            <img src="logo.png" alt="Logo">
                            <p class="font-weight-bold custom-card-text">Tienda física en Guasave, Sinaloa, México</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="rack2.jpg" alt="Imagen 3" class="custom-img">
                        <div class="text-center mt-2">
                            <img src="logo.png" alt="Logo">
                            <p class="font-weight-bold custom-card-text">Envíos a todo México y próximamente a todo el mundo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
