@extends('layouts/app')
@section('titulo', 'Aportes')
@section('content')

    <style>
        .titulo {
            font-size: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.464);
            padding: 10px;
            font-weight: bold;
            margin-bottom: 0;
        }

        .descripcion {
            color: rgb(255, 255, 255);
            font-weight: 500;
            background: rgba(0, 0, 0, 0.378);
            padding: 10px;
            margin-bottom: 0;
            /* text-shadow: 0px 0px 10px rgb(255, 255, 255)!important; */
        }

        .multa {
            background: rgb(171, 11, 11);
            padding: 7px;
            margin-bottom: 0;
        }

        .pie {
            display: flex;
            justify-content: space-between;
            height: auto !important;
            margin-bottom: 10px;
            background: rgba(0, 0, 0, 0.378) !important;
            font-size: 15px !important;
            padding-bottom: 20px;
        }

        .fecha {
            background: rgb(63, 91, 6);
            padding: 7px;
            color: rgb(255, 255, 255);
            font-weight: 600;
        }

        .card div {
            text-align: left;
            text-shadow: 2px 2px black 2px;
            font-size: 17px;
        }

        .card h5 {
            font-weight: bold;
        }

        .total {
            position: absolute;
            top: 0;
            left: 0;
            background: black;
            color: white;
            padding: 10px;
            font-weight: bold;
        }

        .estadoActivo .card-body {
            color: white;
        }

        .estadoInactivo {
            background: rgb(74, 74, 74);
        }

        .modal-body {
            overflow: auto;
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

    <h4 class="text-center text-secondary">LISTA DE APORTES</h4>



    <div class="pb-1 pt-2 d-flex flex-wrap gap-2">

        <a href="" data-toggle="modal" data-target="#registrar" class="btn btn-rounded btn-primary"><i
                class="fas fa-plus"></i>&nbsp;
            Nuevo registro</a>
    </div>

    @error('txtfile')
        <p class="alert alert-danger p-2">{{ $message }}</p>
    @enderror

    <!-- Modal registrar datos aportes-->
    <div class="modal fade" id="registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Crear nuevo Aporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('aportes.store') }}" method="POST">
                        @csrf

                        <div class="mb-4 px-2 col-12">
                            <label>Titulo *</label>
                            <input required type="text" placeholder="Ejemplo: Aporte para el techado de la IE"
                                class="input input__text" name="txttitulo" value="{{ old('txttitulo') }}">
                            @error('txttitulo')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <textarea required name="txtdescripcion" class="input input__text" cols="10" rows="3"
                                placeholder="Descripcion de la reunión"></textarea>
                            @error('txtdescripcion')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="mb-4 px-2 col-12">
                            <label>Monto *</label>
                            <input required type="number" placeholder="S/. 0.00" class="input input__text" name="txtmonto"
                                value="{{ old('txtmonto') }}">
                            @error('txtmonto')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="mb-4 px-2 col-12">
                            <label>Fecha plazo *</label>
                            <input required type="date" class="input input__text" name="txtfecha" id="txtfecha"
                                value="{{ old('txtfecha') }}">
                            @error('txtfecha')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>


                        <div class="text-right p-2">
                            <a data-dismiss="modal" class="btn btn-secondary btn-rounded">Atras</a>
                            <button type="submit" value="ok" name="btnmodificar"
                                class="btn btn-primary btn-rounded">Registrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <section class="card">
        <div class="card-block">
            <div class="row">
                @foreach ($aportes as $item)
                    <div class="col-lg-6 col-md-6 mb-1">
                        <div class="card">
                            <div class="card-body statistic-box bg-info">
                                <p class="card-text titulo">{{ $item->titulo }}</p>
                                <p class="total">{{ $item->total }} aport.</p>
                                <p class="card-text descripcion">{{ $item->descripcion }}</p>
                                <div class="pie">
                                    <p class="card-text multa">Multa: S/. {{ $item->monto }}.00</p>
                                    <p class="card-text fecha">Fecha: {{ $item->fecha }} - Hora: {{ $item->hora }}</p>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#modificar{{ $item->id_aporte }}"
                                    class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('aportes.destroy', $item->id_aporte) }}" method="POST"
                                    class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger eliminar" data-id="{{ $item->id_aporte }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                <a href="{{ route('aportes.aportesReporteExcel', $item->id_aporte) }}"
                                    class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>

                                <a href="{{ route('aportes.reporte', $item->id_aporte) }}" target="_blank"
                                    class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>

                                <a href="{{ route('aportes.vistaAgregarParticipante', $item->id_aporte) }}"
                                    class="btn bg-primary"><i class="fas fa-user-plus"></i> Agregar aportantes</a>

                            </div>
                        </div>
                    </div>

                    <!-- Modal modificar datos usuario-->
                    <div class="modal fade" id="modificar{{ $item->id_aporte }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title w-100" id="exampleModalLabel">Modificar datos del aporte
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('aportes.update', $item->id_aporte) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="mb-4 px-2 col-12">
                                            <label>Titulo *</label>
                                            <input required type="text"
                                                placeholder="Ejemplo: Aporte para el techado de la IE"
                                                class="input input__text" name="txttitulo"
                                                value="{{ old('txttitulo', $item->titulo) }}">
                                            @error('txttitulo')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="fl-flex-label mb-4 px-2 col-12">
                                            <textarea required name="txtdescripcion" class="input input__text" cols="10" rows="3"
                                                placeholder="Descripcion de la reunión">{{ old('txtdescripcion', $item->descripcion) }}</textarea>
                                            @error('txtdescripcion')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Monto *</label>
                                            <input required type="number" placeholder="S/. 0.00"
                                                class="input input__text" name="txtmonto"
                                                value="{{ old('txtmonto', $item->monto) }}">
                                            @error('txtmonto')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Fecha plazo *</label>
                                            <input required type="date" class="input input__text" name="txtfecha"
                                                id="txtfecha" value="{{ old('txtfecha', $item->fechaAp) }}">
                                            @error('txtfecha')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>


                                        <div class="text-right p-2">
                                            <a data-dismiss="modal" class="btn btn-secondary btn-rounded">Atras</a>
                                            <button type="submit" value="ok" name="btnmodificar"
                                                class="btn btn-primary btn-rounded">Modificar</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="text-right">
                {{ $aportes->links('pagination::bootstrap-4') }}
                Mostrando {{ $aportes->firstItem() }} - {{ $aportes->lastItem() }} de
                {{ $aportes->total() }}
                resultados
            </div>

        </div>
    </section>


    <script>
        function confimar_eliminar() {
            let res = confirm('¿Estas seguro de eliminar todos los registros?');
            if (res) {
                return confirm(
                    'Por tu seguridad te preguntamos nuevamente. ¿Estas seguro de eliminar todos los registros?'
                );
            } else {
                return res;
            }
        }

        //bloquear dias menores al dia actual en input txtfecha
        // Obtener la fecha actual
        var fechaActual = new Date().toISOString().split('T')[0];

        // Obtener el campo de fecha
        var txtFecha = document.getElementById('txtfecha');

        // Establecer la fecha mínima en el campo de fecha
        txtFecha.min = fechaActual;
    </script>




@endsection
