@extends('layouts.app')

@section('content')
    <style>
        * {
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: rgb(217, 226, 236);
        }

        h1 {
            text-align: center;
            font-size: 40px;
            color: rgb(32, 42, 63);
            padding: 20px;
            margin: 0;
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
            background: white;
            margin: auto;
            padding: 20px
        }

        .form {
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        input {
            padding: 15px;
            outline: none;
            font-size: 18px;
            font-style: italic;
            color: black !important;
        }

        input:focus {
            font-style: normal;
            font-weight: bold;
        }

        .entrada,
        .salida {
            padding: 18px 10px;
            outline: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
        }

        .entrada {
            background: rgb(0, 153, 255);
        }

        .salida {
            background: rgb(255, 0, 0);
        }

        .entrada:hover {
            background: rgb(0, 119, 199);
            color: white;
        }

        .salida:hover {
            background: rgb(199, 0, 0);
            color: white;
        }

        p {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: rgba(6, 15, 41, 0.838);
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
    </style>

    <!--.side-menu-->

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

    <h2 class="text-center text-secondary pb-2">PANEL DE CONTROL</h2>

    <div class="container-fluid text-center">
        <div class="row">

            <!--.col-->
            <div class="col-12 overflow-hidden">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <article class="statistic-box red">
                            <div>
                                <div class="number text-light">{{ $totalPadres }}</div>
                                <div class="caption">
                                    <div>PADRES</div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!--.col-->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <article class="statistic-box green">
                            <div>
                                <div class="number text-light">{{ $totalEstudiantes }}</div>
                                <div class="caption">
                                    <div>ESTUDIANTES</div>
                                </div>
                            </div>
                        </article>
                    </div>
                   
                    <!--.col-->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <article class="statistic-box yellow">
                            <div>
                                <div class="number text-light">{{ $totalUsuarios }}</div>
                                <div class="caption">
                                    <div>USUARIOS</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    {{-- <div class="col-12">
                    <article class="statistic-box bg-info">
                        <div>
                            <div class="number text-light">1000</div>
                            <div class="caption">
                                <div>TOTAL DEUDA</div>
                            </div>
                        </div>
                    </article>
                </div> --}}
                    <!--.col-->
                </div>
                <!--.row-->
            </div>
            <!--.col-->

            <div class="container">
                <div class="form">
                    @csrf
                    <p>Registra tu asistencia</p>
                    <select id="txtidreunion" class="input input__select">
                        <option value="">Seleccione una reunión...</option>
                        @foreach ($reunionActivo as $item)
                            <option value="{{ $item->id_reunion }}">{{ $item->titulo }}</option>
                        @endforeach
                    </select>
                    <input id="dni" autofocus type="number" name="dni" placeholder="DNI del padre de familia">
                    <div class="group__button">
                        {{-- <a id="salida" href="asistencia-salida" class="salida">SALIDA</a> --}}
                        <a id="entrada" href="asistencia-entrada" class="entrada">MARCAR ASISTENCIA</a>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!--.container-fluid-->
    <!--.page-content-->
    </body>


    <script>
        let entrada = document.getElementById("entrada");
        let salida = document.getElementById("salida");

        entrada.addEventListener("click", function(e) {
            e.preventDefault();
            let dni = document.getElementById("dni").value;
            let id_reunion = document.getElementById("txtidreunion").value;
            if (dni == "" || id_reunion == "") {
                if (dni == "") {
                    alert("Ingrese su DNI");
                } else {
                    alert("Seleccione una reunión");
                }
            } else {
                document.location.href = `asistencia-entrada-${id_reunion}-${dni}`
            }

        })

        salida.addEventListener("click", function(e) {
            e.preventDefault();
            let dni = document.getElementById("dni").value;
            let id_reunion = document.getElementById("txtidreunion").value;
            if (dni == "" || id_reunion == "") {
                if (dni == "") {
                    alert("Ingrese su DNI");
                } else {
                    alert("Seleccione una reunión");
                }
            } else {
                document.location.href = `asistencia-salida-${id_reunion}-${dni}`
            }
        })
    </script>

    <script>
        setInterval(() => {
            let timeNow = new Date();
            let fecha = timeNow.toLocaleString();
            let mainTime = `${fecha}`;
            document.getElementById("time").innerHTML = mainTime;
        }, 1000);
    </script>

    <script>
        let dni = document.getElementById("dni");
        dni.addEventListener("input", function() {
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8)
            }
        })


        //eventos para la entrada y salida
        document.addEventListener("keyup", function(event) {
            if (event.code == "ArrowLeft") {
                document.getElementById("salida").click()
            } else {
                if (event.code == "ArrowRight") {
                    document.getElementById("entrada").click()
                }
            }
        })
    </script>
@endsection
