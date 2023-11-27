@extends('layouts/app')
@section('titulo', 'Reuniones')
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
            height: 70vh;
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

    <h4 class="text-center text-secondary">LISTA DE REUNIONES</h4>

    <div class="pb-1 pt-2 d-flex flex-wrap gap-2">

        <a href="" data-toggle="modal" data-target="#registrar" class="btn btn-rounded btn-primary"><i
                class="fas fa-plus"></i>&nbsp;
            Nuevo registro</a>
    </div>

    @error('txtfile')
        <p class="alert alert-danger p-2">{{ $message }}</p>
    @enderror

    <!-- Modal registrar datos usuario-->
    <div class="modal fade" id="registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Crear reunión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reuniones.store') }}" method="POST">
                        @csrf

                        <div class="mb-4 px-2 col-12">
                            <label>Titulo de la reunion *</label>
                            <input required type="text" placeholder="Ejemplo: Reunion general" class="input input__text"
                                name="txttitulo" value="{{ old('txttitulo') }}">
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
                            <label>Multa *</label>
                            <input required type="number" placeholder="S/. 0.00" class="input input__text" name="txtmulta"
                                value="{{ old('txtmulta') }}">
                            @error('txtmulta')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="mb-4 px-2 col-12">
                            <label>Fecha de la reunión *</label>
                            <input required type="date" class="input input__text" name="txtfecha" id="txtfecha"
                                value="{{ old('txtfecha') }}">
                            @error('txtfecha')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="mb-4 px-2 col-12">
                            <label>Hora de la reunión *</label>
                            <input required type="time" class="input input__text" name="txthora"
                                value="{{ old('txthora') }}">
                            @error('txthora')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="mb-4 px-2 col-12">
                            <label>Estado de la reunión *</label>
                            <select name="txtestado" class="input input__select">
                                @foreach ($estado as $item)
                                    <option value="{{ $item->id_estado_reunion }}">{{ $item->estado }}</option>
                                @endforeach
                            </select>
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
                @foreach ($reuniones as $item)
                    <div class="col-lg-6 col-md-6 mb-1">
                        <div class="card">
                            <div
                                class="card-body statistic-box {{ $item->id_estado_reunion == 1 ? 'green' : 'estadoInactivo' }}">
                                <p class="card-text titulo">{{ $item->titulo }}</p>
                                <p class="total">{{ $item->total }} part.</p>
                                <p class="card-text descripcion">{{ $item->descripcion }}</p>
                                <div class="pie">
                                    <p class="card-text multa">Multa: S/. {{ $item->multa_precio }}.00</p>
                                    <p class="card-text fecha">Fecha: {{ $item->fecha }} - Hora: {{ $item->hora }}</p>
                                </div>
                                {{-- <p class="card-text">{{ $item->estado }}</p> --}}
                                {{-- <h5 class="card-title">ID: {{ $item->id_reunion }}</h5> --}}
                                <a href="#" data-toggle="modal" data-target="#modificar{{ $item->id_reunion }}"
                                    class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('reuniones.destroy', $item->id_reunion) }}" method="POST"
                                    class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger eliminar" data-id="{{ $item->id_reunion }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                {{-- agregar dos botones de reporte excel y pdf --}}
                                <a href="{{ route('reuniones.reunionesReporteExcel', $item->id_reunion) }}"
                                    class="btn btn-success"><i class="fas fa-file-excel"> Excel</i></a>

                                <a href="{{ route('reuniones.reporte', $item->id_reunion) }}" target="_blank" class="btn btn-danger"><i
                                        class="fas fa-file-pdf"></i> PDF</a>


                                {{-- agregar un boton de agregar participantes --}}
                                <a href="{{ route('reuniones.vistaAgregarParticipante', $item->id_reunion) }}"
                                    class="btn bg-primary"><i class="fas fa-user-plus"></i> Agregar participantes</a>

                            </div>
                        </div>
                    </div>

                    <!-- Modal modificar datos usuario-->
                    <div class="modal fade" id="modificar{{ $item->id_reunion }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title w-100" id="exampleModalLabel">Modificar datos de la reunión
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('reuniones.update', $item->id_reunion) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="mb-4 px-2 col-12">
                                            <label>Titulo de la reunion *</label>
                                            <input required type="text" placeholder="Ejemplo: Reunion general"
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
                                            <label>Multa *</label>
                                            <input required type="number" placeholder="S/. 0.00"
                                                class="input input__text" name="txtmulta"
                                                value="{{ old('txtmulta', $item->multa_precio) }}">
                                            @error('txtmulta')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Fecha de la reunión *</label>
                                            <input required type="date" class="input input__text" name="txtfecha"
                                                id="txtfecha" value="{{ old('txtfecha', $item->fecha) }}">
                                            @error('txtfecha')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Hora de la reunión *</label>
                                            <input required type="time" class="input input__text" name="txthora"
                                                value="{{ old('txthora', $item->hora) }}">
                                            @error('txthora')
                                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4 px-2 col-12">
                                            <label>Estado de la reunión *</label>
                                            <select name="txtestado" class="input input__select">
                                                @foreach ($estado as $item2)
                                                    <option
                                                        {{ $item->id_estado_reunion == $item2->id_estado_reunion ? 'selected' : '' }}
                                                        value="{{ $item2->id_estado_reunion }}">{{ $item2->estado }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                {{ $reuniones->links('pagination::bootstrap-4') }}
                Mostrando {{ $reuniones->firstItem() }} - {{ $reuniones->lastItem() }} de
                {{ $reuniones->total() }}
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
