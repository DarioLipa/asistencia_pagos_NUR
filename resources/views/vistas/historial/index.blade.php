@extends('layouts/app')
@section('titulo', 'Historial')
@section('content')


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

    <h4 class="text-center text-secondary">HISTORIAL DE PADRES</h4>


    <form action="#" id="formBuscar">
        <div class="form-group row col-12 px-4">
            <div class="col-12 col-sm-9">
                <input autofocus type="number" id="dni" class="form-control p-3"
                    placeholder="Ingrese el DNI del padre de familia" name="txtdni">
            </div>
            <button id="buscar" class="btn btn-success col-12 col-sm-3 mt-2 mt-sm-0" type="submit">Buscar</button>
        </div>
    </form>

    <div class="card-block" style="margin-bottom: -40px">
        <div id="resultado"></div>
    </div>

    <div class="card-block table-responsive">
        {{-- hacer boton de descargar pdf con su icono de fontawesome --}}
        <a href="" target="_blank" id="descarga" class="btn btn-danger mb-3 disabled"><i
                class="fas fa-file-pdf"></i> Descargar
            PDF</a>

        <table id="" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th colspan="8" class="text-center bg-info">APORTES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Monto que debe aportar</th>
                    <th>Monto aportado</th>
                    <th>Monto que debe</th>
                    <th>Fecha plazo</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody id="tbody">

            </tbody>
        </table>
    </div>

    <div class="card-block table-responsive">
        <table id="" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th colspan="6" class="text-center bg-info">REUNIONES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Multa</th>
                    <th>Fecha y hora de la reunion</th>
                    <th>Asistencia</th>
                    {{-- <th>Estado de la reunion</th> --}}
                </tr>
            </thead>

            <tbody id="tbodyreuniones">

            </tbody>
        </table>
    </div>


    <script>
        //enviando datos para la busqueda por ajax
        let formBuscar = document.getElementById("formBuscar");
        let dni = document.getElementById("dni");
        formBuscar.addEventListener("submit", buscarDatos);
        // formBuscar.addEventListener("blur", buscarDatos);
        // formBuscar.addEventListener("keyup", buscarDatos);
        //dni.addEventListener("blur", buscarDatos);
        //dni.addEventListener("keyup", buscarDatos);

        function buscarDatos(ev) {
            ev.preventDefault();
            let datos = $(this).serialize();
            $.ajax({
                url: "{{ route('historial.show') }}",
                type: "get",
                data: datos,

                success: function(response) {
                    let tbody = document.getElementById("tbody")
                    tbody.innerHTML = ""
                    let tbodyreuniones = document.getElementById("tbodyreuniones")
                    tbodyreuniones.innerHTML = ""
                    let respuesta = document.getElementById("resultado")
                    respuesta.innerHTML =
                        `<div class="alert alert-success p-3">PADRE DE FAMILIA: ${response.nombrePadreFamilia}</div>`

                    //habilitamos la descarga
                    let descarga = document.getElementById("descarga")
                    descarga.classList.remove("disabled")
                    descarga.setAttribute("href",
                        `{{ route('historial.descargaPDF', ['dni_padre' => ':dni_padre']) }}`.replace(
                            ':dni_padre', response
                            .dni)
                    );

                    response.historialAportes.forEach(function(element, index) {
                        let fila = document.createElement("tr")
                        fila.innerHTML = `
                        <td>${index+1}</td>
                        <td>${element.titulo}</td>
                        <td>${element.descripcion}</td>
                        <td>S/. ${element.monto} <b>X ${response.cantidadHijos} Hijos = S/. ${element.monto_aporte}<b></td>
                        <td><span class='text-white btn-sm bg-success font-weight-bold'>${element.monto_aportado==null ? "---": "S/. " + element.monto_aportado}</span></td>
                        <td><span class='text-white btn-sm bg-dark font-weight-bold'>${element.debe==null ? "---": "S/. " + element.debe}</span></td>
                        <td>${element.fecha}</td>
                        <td>${(element.debe==null | element.debe>0)? "<span class='btn btn-sm btn-danger'>Debe</span>": "<span class='btn btn-sm btn-success'>Pagado</span>"}</td>
                        `
                        tbody.appendChild(fila)
                    });

                    response.historialReuniones.forEach(function(element, index) {
                        let fila = document.createElement("tr")
                        let asistenciaHTML = "";

                        if (element.asistencia == null && (element.detalles == '' || element.detalles ==
                                null)) {
                            asistenciaHTML = "<span class='btn btn-sm btn-danger'>Falta</span>";
                        } else {
                            asistenciaHTML = element.asistencia !== null && element.asistencia !== '' ?
                                `<span class='btn btn-sm btn-success'>${element.asistencia}</span>` :
                                `<span class='btn btn-sm btn-success'>${element.detalles}</span>`;
                        }
                        fila.innerHTML = `
                        <td>${index+1}</td>
                        <td>${element.titulo}</td>
                        <td>${element.descripcion}</td>
                        <td><span class='text-white btn-sm bg-dark font-weight-bold'>S/. ${element.multa_precio}</span></td>
                        <td>${element.fecha +" "+ element.hora}</td>
                        <td>${asistenciaHTML}</td>
                        `
                        tbodyreuniones.appendChild(fila)
                        //<td>${element.estado=="ACTIVO" ? `<span class='btn btn-sm btn-success'>${element.estado}</span>`: `<span class='btn btn-sm btn-danger'>${element.estado}</span>`}</td>
                    });

                },
                error: function(datos) {
                    //deshabilitamos la descarga
                    let descarga = document.getElementById("descarga")
                    descarga.classList.add("disabled")
                    let tbody = document.getElementById("tbody")
                    tbody.innerHTML = ""
                    let tbodyreuniones = document.getElementById("tbodyreuniones")
                    tbodyreuniones.innerHTML = ""

                    let respuesta = document.getElementById("resultado")
                    respuesta.innerHTML =
                        `<div class="alert alert-danger p-3">No se encontro el DNI</div>`
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: `${datos.responseJSON.message}`,
                            styling: "bootstrap3"
                        });
                    });
                }
            });
        }
    </script>

@endsection
