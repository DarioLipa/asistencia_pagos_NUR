@extends('layouts/app')
@section('titulo', 'Escanear')
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
@section('content')

    <style>
        .page-content {
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            align-content: center;
        }

        .vistaCamara {
            margin-top: 10px;
            width: 70vh;
            height: 70vh;
            position: relative;
            overflow: hidden;
        }

        #preview {
            background: rgb(255, 255, 255);
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        @media screen and (max-width: 450px) {
            .vistaCamara {
                width: 40vh;
                height: 40vh;
            }
        }
    </style>

    {{-- notificaciones --}}


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

    <audio hidden controls src="{{ asset('mp3/pitido.mp3') }}" id="audio"></audio>
    <input type="hidden" id="id" value="{{ $id }}">

    @foreach ($tituloReunion as $item)
        <h4 class="w-100 text-center text-white p-3 bg-dark font-weight-bold mb-1">{{ $item->titulo }}</h4>
        <input type="hidden" value="{{ $item->id_reunion }}">
    @endforeach

    <div class="contenedor">

        <button onclick="switchCamera()" class="btn btn-primary mb-2"><i class="fas fa-sync-alt"></i>
            CAMBIAR CÁMARA</button>
    </div>



    <div class="col-8 vistaCamara"><video id="preview"></video></div>

    <script type="text/javascript">
        let scanner;
        let activeCamera = 0;

        function switchCamera() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 1) {
                    activeCamera = (activeCamera + 1) % cameras.length;
                    scanner.start(cameras[activeCamera]);
                }
            });
        }



        //ejecutar funcion al cargar la pagina
        $(document).ready(function() {
            Instascan.Camera.getCameras().then(function(cameras) {
                var backCamera = cameras.find(function(camera) {
                    return camera.name && camera.name.indexOf('back') !== -1;
                });
                // utiliza la cámara trasera si está disponible
                if (backCamera) {
                    scanner.start(backCamera);
                    activeCamera = cameras.indexOf(backCamera);
                } else if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                    activeCamera = 0;
                } else {
                    console.error('No se encontraron cámaras disponibles.');
                }
            }).catch(function(e) {
                console.error(e);
            });

            //hacer condicion si es camara frontal poner mirror:true caso contrario mirror:false

            //verificar si es pc o movil
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                scanner = new Instascan.Scanner({
                    video: document.getElementById('preview'),
                    mirror: false
                });
            } else {
                scanner = new Instascan.Scanner({
                    video: document.getElementById('preview'),
                    mirror: true
                });
            }

            var id = document.getElementById("id").value;
            scanner.addListener('scan', function(content) {
                console.log(content);
                var url = "{{ route('asistencia.entrada', [':id_reunion', ':id_padre_familia']) }}"
                .replace(':id_reunion', id)  // Reemplazar con el id que deseas enviar
                .replace(':id_padre_familia', content);
                window.location.href = url;
                document.getElementById("audio").play();
            });
        });
    </script>





@endsection
