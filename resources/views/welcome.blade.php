<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- pNotify --}}
    <link href="{{ asset('welcome/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- PNotify -->
    <link href="{{ asset('welcome/css/pnotify.css') }}" rel="stylesheet" />
    <link href="{{ asset('welcome/css/pnotify.buttons.css') }}" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="{{ asset('welcome/css/custom.min.css') }}" rel="stylesheet" />
    <!-- SCRIPTS PARA NOTIFICACION -->
    <!-- jQuery -->
    <script src="{{ asset('welcome/js/jquery.min.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('pnotify/js/jquery.min.js') }}"></script>
    <script src="{{ asset('welcome/js/pnotify.js') }}"></script>
    <script src="{{ asset('welcome/js/pnotify.buttons.js') }}"></script>

    <style>
        * {
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: rgb(217, 236, 223);
            background-image: url("{{ asset('img-inicio/fondo.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .overlay {
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.13);
            position: absolute;
            top: 0;
            right: 0;
            z-index: 0;
            filter: blur(10px);
        }

        h1 {
            text-align: center;
            font-size: 40px;
            color: rgb(0, 64, 75);
            padding: 20px;
            margin: 0;
            position: relative;
            background: rgba(255, 255, 255, 0.622);
            text-shadow: 1px 1px 0px rgb(15, 63, 79), 2px 2px 0px rgb(15, 63, 79);
        }

        h2 {
            text-align: center;
            font-size: 30px;
            color: rgb(148, 148, 148);
            font-weight: normal;
            margin-top: 0;
        }

        div.container {
            width: 90%;
            max-width: 680px;
            background: rgba(255, 255, 255, 0.971);
            margin: auto;
            padding: 20px;
            position: relative;
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        input {
            padding: 25px;
            outline: none;
            font-size: 22px;
            font-style: italic;
        }

        input:focus {
            font-style: normal;
            font-weight: bold;
        }

        .buscar {
            padding: 18px 10px;
            outline: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            background: rgb(2, 118, 206);
        }

        .buscar:hover {
            background: rgb(0, 162, 255);
        }

        p {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            color: rgb(9, 17, 41);
            margin: 0;
        }

        .login {
            font-style: italic;
            font-size: 20px;
            font-weight: bold;
            color: rgb(0, 121, 235);
        }

        .group__button {
            width: 100%;
            padding: 0;
            display: flex;

        }

        .marca {
            width: 100%;
            margin: 0;
            background: rgb(13, 39, 48);
            position: fixed;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .marca__parrafo {
            margin: 0 !important;
            color: white;
            font-size: 15px;
            font-weight: normal;
        }

        .marca__texto {
            color: rgb(0, 162, 255);
            text-decoration: underline;
        }

        .marca__parrafo span {
            color: red;
        }

        .tituloReu {
            max-width: 670px;
            min-width: 300px;
            text-align: center;
            padding: 10px;
            background: rgb(50, 142, 96);
            color: white;
            margin: auto;
            margin-bottom: 0;
            margin-top: 20px;
            position: relative;
        }
    </style>

    {{-- estilos de card de reuniones --}}
    <style>
        /* Estilos para la tarjeta */
        .row {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .card {
            border-radius: 4px;
            background-color: white;
            margin: 16px;
            width: 320px;
            background: #fefefe;
            margin-top: 0;
            position: relative;

        }

        .card-body {
            padding: 16px;
        }

        .card-text {
            font-size: 16px;
            color: rgba(0, 0, 0, 0.87);
        }

        .titulo {
            font-weight: bold;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
            color: rgb(255, 255, 255);
            background: rgb(0, 182, 88);
            padding: 8px;
        }

        .descripcion {
            font-size: 14px;
            padding: 8px;
            color: rgb(33, 33, 33);
            font-weight: normal;
        }

        .multa {
            color: #6c0a22;
            font-size: 13px;
            padding: 4px;
            background: rgb(255, 225, 225);            
        }

        .fecha {
            font-size: 13px;
            color: rgb(57, 54, 9);
            background: rgb(249, 255, 186);
            padding: 8px;
        }

        .mensaje-error {
            padding: 10px;
            background: rgb(253, 203, 203);
            color: rgb(51, 8, 8);
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>


<body class="antialiased">

    <div class="overlay"></div>

    <h1>BIENVENIDOS AL SISTEMA DE APAFA</h1>
    {{-- <h2 class="main_time" id="time"><?= date('d/m/Y, h:i:s') ?></h2> --}}
    <div class="container">
        <a class="login" href="{{ route('home') }}">Ingresar al sistema</a>
        <div id="respuesta"></div>
        <div class="form">
            @csrf
            <p>Ingrese su DNI</p>
            <input id="dni" autofocus type="number" name="dni" placeholder="DNI del padre de familia">
            <div class="group__button">
                <a id="buscar" href="asistencia-buscar" class="buscar">BUSCAR MI HISTORIAL</a>
            </div>
        </div>
    </div>

    {{-- <h4 class="tituloReu">Reuniones pendientes</h4>
    <div class="row">
        @foreach ($reunionActivo as $item)
            <div class="card">
                <div class="card-body">
                    <p class="card-text titulo">{{ $item->titulo }}</p>
                    <div class="pie">
                        <p class="card-text multa">Multa: S/. {{ $item->multa_precio }}.00</p>
                        <p class="card-text fecha">Fecha: {{ $item->fecha }} - Hora: {{ $item->hora }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}

    @if (session('CORRECTO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "CORRECTO",
                    type: "success",
                    text: "{{ session('CORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif



    @if (session('INCORRECTO'))
        <script>
            // document.getElementById("audio1").play();
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "{{ session('INCORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('ERROR'))
        <script>
            document.getElementById("audio1").play();
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "{{ session('ERROR') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif




</body>

<script>
    let buscar = document.getElementById("buscar");

    buscar.addEventListener("click", eventoBuscar)

    function eventoBuscar(e) {
        e.preventDefault();
        let dni = document.getElementById("dni").value;

        if (dni == "") {
            alert("Ingrese su DNI");
            return false;
        } else {
            //abrir en una nueva pestaña
            let valor = document.getElementById("dni").value;
            var ruta = "{{ url('buscar-padres') }}-" + valor + "";
            console.log("bien")
            $.ajax({
                url: ruta,
                type: "get",
                success: function(data) {
                    window.open(`historial-descargarPDF-${dni}`, '_blank');
                },
                error: function(data) {
                    let res = document.getElementById("respuesta")
                    res.innerHTML = `<div class="mensaje-error">El DNI ingresado no esta registrado...</div>`
                    return false;
                }
            })


        }

    }
</script>


<script>
    let dni = document.getElementById("dni");
    dni.addEventListener("input", function() {
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8)
        }
    })
</script>

</html>
