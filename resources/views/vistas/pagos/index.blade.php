@extends('layouts/app')
@section('titulo', 'Pagos')
@section('content')

    <style>
        .rojo {
            background-color: #ffcccc !important;
            color: rgb(58, 12, 12) !important;
        }

        .verde {
            background-color: #ccffcc !important;
            color: rgb(7, 50, 26) !important;
        }

        .card-block {
            max-height: 400px;

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

    @if (session('id_pago'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "CORRECTO",
                    type: "success",
                    text: "El pago se realizo con exito",
                    styling: "bootstrap3"
                });
            });
        </script>

        {{-- abrir en una nueva pestaña la ruta pagoTicket y enviar el id del padre como parametro --}}
        <script>
            $(function() {
                window.open("{{ route('pagos.ticketPago', ':id_pago') }}".replace(':id_pago', '{{ session("id_pago") }}'), "_blank");
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

    <h4 class="text-center text-secondary">REALIZA TUS PAGOS</h4>

    <div class="card-block" style="margin-bottom: -40px">
        <div class="alert alert-success p-3">
            @foreach ($nombrePadreFamilia as $item)
                {{ $item->nombre }}
            @endforeach
        </div>
    </div>

    <div class="card-block table-responsive table-one">

        <table id="example2" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th colspan="9" class="text-center bg-info">APORTES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Monto que debe aportar</th>
                    <th>Monto aportado</th>
                    <th>Monto que debe</th>
                    <th>Fecha plazo</th>
                    {{-- <th>Estado</th> --}}
                    <th></th>
                </tr>
            </thead>

            <tbody id="tbody">
                @foreach ($historialAportes as $key => $item)
                    <tr class="{{ ($item->debe == null) | ($item->debe > 0) ? 'rojo' : 'verde' }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>S/. {{ $item->monto }} <b>X {{ $cantidadHijos }} Hijos = {{ $item->monto_aporte }}</b></td>
                        <td>S/. {{ $item->monto_aportado }}</td>
                        <td>S/. {{ $item->debe }}</td>
                        <td>{{ $item->fecha }}</td>
                        {{-- <td>
                            @if ($item->debe == null)
                                <span class="btn btn-sm btn-danger">Debe</span>
                            @else
                                <span class="btn btn-sm btn-success">Pagado</span>
                            @endif
                        </td> --}}
                        <td>
                            @if ($item->debe == null || $item->debe > 0)
                                <a href="" data-toggle="modal" data-target="#registrar{{ $item->id_aporte }}"
                                    class="btn btn-sm bg-dark"><i class="fas fa-dollar-sign"></i> Pagar</a>
                            @else
                                <a href="" class="btn btn-sm bg-dark disabled"><i class="fas fa-dollar-sign"></i>
                                    Pagar</a>
                            @endif
                        </td>
                    </tr>


                    <!-- Modal registrar pago de aportes -->
                    <div class="modal fade" id="registrar{{ $item->id_aporte }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title w-100" id="exampleModalLabel">Registrar Pago</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('pagos.store') }}" method="POST"
                                        data-form-id="formAporte-{{ $item->id_aporte }}">
                                        @csrf

                                        <input type="hidden" name="txtidaporte" value="{{ $item->id_aporte }}">
                                        <input type="hidden" name="txtidpadre" value="{{ $item->id_padre_familia }}">
                                        <input type="hidden" name="txtidusuario" value="{{ Auth::user()->id_usuario }}">

                                        <div class="mb-4 px-2 col-12">
                                            <label>Monto que queda por aportar</label>
                                            <input required readonly type="text" placeholder="Monto a aportar"
                                                name="txtmontoapotar" class="input input__text"
                                                data-form-id="txtmontoaportar-{{ $item->id_aporte }}"
                                                value="{{ old('txtmontoaportar', $item->monto_aporte - $item->monto_aportado) }}">
                                            @error('txtmontoaportar')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>


                                        <div class="mb-4 px-2 col-12">
                                            <label>Monto aportado</label>
                                            <input required type="number" step="0.5" placeholder=""
                                                class="input input__text" name="txtmontoaportado"
                                                data-form-id="txtmontoaportado-{{ $item->id_aporte }}"
                                                class="monto-aportado" value="{{ old('txtmontoaportado') }}">
                                            @error('txtmontoaportado')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Monto que debe</label>
                                            <input required readonly type="text" placeholder=""
                                                data-form-id="txtmontodebe-{{ $item->id_aporte }}"
                                                class="input input__text" name="txtmontodebe"
                                                value="{{ old('txtmontodebe', $item->debe) }}">
                                            @error('txtmontodebe')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>



                                        <div class="text-right p-2">
                                            <a data-dismiss="modal" class="btn btn-secondary btn-rounded">Atras</a>
                                            <button type="submit" value="ok" name="btnmodificar"
                                                class="btn btn-primary btn-rounded">Registrar pago</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="card-block table-responsive">
        <table id="example3" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th colspan="8" class="text-center bg-info">REUNIONES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Multa</th>
                    <th>Fecha y hora de la reunion</th>
                    <th>Asistencia</th>
                    <th>Estado de la reunion</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tbodyreuniones">
                @foreach ($historialReuniones as $key => $item)
                    <tr
                        class="{{ $item->asistencia == null && ($item->detalles == '' || $item->detalles == null) ? 'rojo' : 'verde' }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>S/. {{ $item->multa_precio }}</td>
                        <td>{{ $item->fecha }} - {{ $item->hora }}</td>
                        <td>
                            @if ($item->asistencia == null and ($item->detalles == '' or $item->detalles == null))
                                <span class="btn btn-sm btn-danger">Falta</span>
                            @else
                                @if ($item->asistencia != null or $item->asistencia != '')
                                    <span class="btn btn-sm btn-success">{{ $item->asistencia }}</span>
                                @else
                                    <span class="btn btn-sm btn-success">{{ $item->detalles }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($item->estado == 'ACTIVO')
                                <span class="btn btn-sm btn-success">{{ $item->estado }}</span>
                            @else
                                <span class="btn btn-sm btn-danger">{{ $item->estado }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->asistencia == null and ($item->detalles == '' or $item->detalles == null))
                                <a href="" data-toggle="modal" data-target="#multa{{ $item->id_reunion }}"
                                    class="btn btn-sm bg-dark"><i class="fas fa-dollar-sign"></i> Pagar</a>
                            @else
                                <a href="" class="btn btn-sm bg-dark disabled"><i class="fas fa-dollar-sign"></i>
                                    Pagar</a>
                            @endif
                        </td>

                    </tr>

                    <!-- Modal registrar multa de reunion-->
                    <div class="modal fade" id="multa{{ $item->id_reunion }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title w-100" id="exampleModalLabel">Registrar Pago</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('pagos.pagarMultaReunion') }}" method="POST"
                                        data-form-id="formMulta-{{ $item->id_reunion }}">
                                        @csrf

                                        <input type="hidden" name="txtidreunion" value="{{ $item->id_reunion }}">
                                        <input type="hidden" name="txtidpadre" value="{{ $item->id_padre_familia }}">
                                        <input type="hidden" name="txtidusuario"
                                            value="{{ Auth::user()->id_usuario }}">

                                        <div class="mb-4 px-2 col-12">
                                            <label>Multa de la reunión</label>
                                            <input required readonly type="text" placeholder="Multa de la reunión"
                                                name="txtmulta" class="input input__text"
                                                data-form-id="txtmulta-{{ $item->id_reunion }}"
                                                value="{{ old('txtmulta', $item->multa_precio) }}">
                                            @error('txtmulta')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>


                                        <div class="mb-4 px-2 col-12">
                                            <label>Monto pago</label>
                                            <input required readonly type="number" step="0.5" placeholder=""
                                                class="input input__text" name="txtpago"
                                                data-form-id="txtpago-{{ $item->id_reunion }}" class="monto-aportado"
                                                value="{{ old('txtpago', $item->multa_precio) }}">
                                            @error('txtpago')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="text-right p-2">
                                            <a data-dismiss="modal" class="btn btn-secondary btn-rounded">Atras</a>
                                            <button type="submit" value="ok" name="btnmodificar"
                                                class="btn btn-primary btn-rounded">Registrar pago</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        let formAporte = document.querySelectorAll('[data-form-id^="formAporte-"]');
        let montoAportado = document.querySelectorAll('[data-form-id^="txtmontoaportado-"]');
        let montoDebe = document.querySelectorAll('[data-form-id^="txtmontodebe-"]');

        montoAportado.forEach((elemento) => {
            elemento.addEventListener('keyup', () => {
                let id = elemento.getAttribute('data-form-id');
                let idAporte = id.split('-')[1];
                let montoAportar = document.querySelector(`[data-form-id="txtmontoaportar-${idAporte}"]`)
                    .value;
                let montoAportado = parseFloat(elemento.value);
                let montoDebe = document.querySelector(`[data-form-id="txtmontodebe-${idAporte}"]`).value;
                //validar que el monto aportado no sea mayor al monto a aportar caso contrario poner el valor del monto a aportar

                if (montoAportado > montoAportar) {
                    elemento.value = montoAportar;
                    montoAportado = montoAportar;
                }
                //validar que el monto aportado no sea menor a 0 caso contrario poner el valor 0
                if (montoAportado < 0) {
                    elemento.value = 0;
                    montoAportado = 0;
                }

                //validar si esta vacio el monto aportado poner el valor 0
                if (montoAportado == '') {
                    elemento.value = 0;
                    montoAportado = 0;
                }

                let montoTotal = montoAportar - montoAportado;
                document.querySelector(`[data-form-id="txtmontodebe-${idAporte}"]`).value = montoTotal;
            })

        })
    </script>

    <script>
        let formMulta = document.querySelectorAll('[data-form-id^="formMulta-"]');
        let montoPago = document.querySelectorAll('[data-form-id^="txtpago-"]');
        let montoMulta = document.querySelectorAll('[data-form-id^="txtmulta-"]');

        montoPago.forEach((elemento) => {
            elemento.addEventListener('keyup', () => {
                let id = elemento.getAttribute('data-form-id');
                let idAporte = id.split('-')[1];
                let montoAportar = document.querySelector(`[data-form-id="txtmulta-${idAporte}"]`)
                    .value;
                let montoPago = parseFloat(elemento.value);
                let montoMulta = document.querySelector(`[data-form-id="txtmulta-${idAporte}"]`).value;
                //validar que el monto aportado no sea mayor al monto a aportar caso contrario poner el valor del monto a aportar

                if (montoPago > montoAportar) {
                    elemento.value = montoAportar;
                    montoPago = montoAportar;
                }
                //validar que el monto aportado no sea menor a 0 caso contrario poner el valor 0
                if (montoPago < 0) {
                    elemento.value = 0;
                    montoPago = 0;
                }

                //validar si esta vacio el monto aportado poner el valor 0
                if (montoPago == '') {
                    elemento.value = 0;
                    montoPago = 0;
                }

                // validar que el monto sea igual a la multa
                if (montoPago != montoMulta) {
                    elemento.value = montoMulta;
                    montoPago = montoMulta;
                }

            })

        })
    </script>






@endsection
