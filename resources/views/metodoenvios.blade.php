<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lia Store Tienda Online</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @extends('layouts.app')

@section('content')
    <style>


        .container {
            display: flex;
            flex-wrap: wrap;
        }
        .panel {
            flex-basis: 50%;
            padding: 30px;
            box-sizing: border-box;
        }
        .right-panel {
            background-color: #f2f2f2;
        }
        .hidden {
            display: none;
        }
        .caja-texto {
            margin-bottom: 20px;
            position: relative;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            
        }
        #cajaSuperiorTexto {
            font-size: 18px;
            margin-bottom: 10px;
        }
        #editarEnlace {
            align-self: flex-end;
        }
        #botonInferior {
            align-self: flex-end;
            margin-top: 10px;
            margin-right: 10px;
        }
        .nuevo-contenedor {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        .seccion {
            flex-basis: 30%;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .seleccionado .circulo {
            background-color: #4285f4;
        }
        .circulo {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #4285f4;
            margin-bottom: 10px;
            display: inline-block;
        }
        #volverEnlace {
            color: #4285f4;
            text-decoration: none;
            margin-right: 20px;
        }
        #continuarBoton {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 50px;
            margin-left: 190px;
        }
        .article {
            display: flex;
            flex-wrap: wrap;
            border-radius: 8px;
            margin-top: 15px;
            width: 100%;
            height: 180px;
            font-weight: bold;
        }
        .article img {
            width: 60px;
            height: 60px;
            background-repeat: no-repeat;
            margin-top: 11px;
            margin-left: 12px;
            background-position: center;
        }
        .panel-two {
            width: 40%;
        }
        .article2 {
            border: 2px solid grey;
            border-radius: 8px;
            margin-top: 15px;
            width: 85px;
            height: 85px;
            
        }
        .info {
            margin-left: 100px;
            margin-top: -65px;
            font-weight: bold;
        }

        .infprecios {
            padding: 50px;
            margin-top: -235px;
            margin-left: 245px;
            width: 35.2%;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="panel left-panel">
            <h2>Lia Store Tienda Online</h2>
            <h5>Carrito ><span> Informacion > Envios</span></h5>

            <div class="mini-container">
                <div class="caja-texto">
                    <p style=" font-weight: bold;"id="cajaSuperiorTexto">Contacto:</p>
                    <textarea style=" font-weight: bold;" id="cajaInferiorCorreo" placeholder="Correo Electrónico" rows="1" readonly>ccjj9703@gmail.com</textarea>
                    <a href="#" id="editarEnlace" onclick="editarCaja('cajaInferiorCorreo')">Cambiar correo electrónico</a>
                </div>
            </div>

            <div class="mini-container">
                <div class="caja-texto">
                    <p style=" font-weight: bold;" id="cajaSuperiorTexto">Enviar a:</p>
                    <textarea style=" font-weight: bold;" id="cajaInferiorDireccion" placeholder="Dirección" rows="1" readonly>Col. Bosque #574</textarea>
                    <a href="#" id="editarEnlace" onclick="editarCaja('cajaInferiorDireccion')">Cambiar Dirección</a>
                </div>
            </div>

            <div class="nuevo-contenedor">
                <div class="seccion" onclick="seleccionarSeccion(1)">
                    <div class="circulo"></div>
                    <p>5-7 Dias Gratis</p>
                </div>
                <div class="seccion" onclick="seleccionarSeccion(2)">
                    <div class="circulo"></div>
                    <p>2-7 Dias $95.00 MXN</p>
                </div>
                <div class="seccion" onclick="seleccionarSeccion(3)">
                    <div class="circulo"></div>
                    <p>1-3 Dias $185.00 MXN</p>
                </div>
            </div>
            <a href="informacion.php" id="volverEnlace">Volver a Información</a>
            <button id="continuarBoton">CONTINUAR</button>
        </div>

        <div class="panel right-panel">
            <div class="article">
                <div class="panel panel-one">
                    <div class="article2">
                        <img src="vestidowhite.jpg" alt="Imagenpqueña">
                    </div>
                    <div class="info">
                        <h4>Vestido Mini</h4>
                        <h5 class="sub-detail">chico</h5>
                    </div>

                    <div class="data-one">
                        <p class="">Subtotal:</p>
                        <p class="">Envios:</p>
                        <p style="font-weight: bold;">Total:</p>
                        <p style="color: grey; opacity: 50%;">Incluye impuestos</p>
                    </div>
                </div>
                <div class="infprecios">
                    <p style="color: grey; opacity: 50%;" class="subtotal">$100.00 </p>
                    <p style="color: grey; opacity: 50%;" class="envios">Calculando..</p>
                    <p style="color: grey; opacity: 50%;" class="total">$150.00 </p>
                </div>
            </div>
    <script>
        function editarCaja(elementId) {
            var element = document.getElementById(elementId);
            element.removeAttribute('readonly');
            element.focus();
        }

        function seleccionarSeccion(seccion) {
            var circulos = document.querySelectorAll('.circulo');

            circulos.forEach(function (circuloElement, index) {
                if (index + 1 === seccion) {
                    circuloElement.parentElement.classList.add('seleccionado');
                } else {
                    circuloElement.parentElement.classList.remove('seleccionado');
                }
            });
        }
    </script>

</body>
</html>
@endsection
