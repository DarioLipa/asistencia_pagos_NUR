@extends('layouts/app')
@section('titulo', 'Estudiantes')
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

    <h4 class="text-center text-secondary">LISTA DE ESTUDIANTES</h4>


    <form action="#" id="formBuscar">
        <div class="form-group row col-12 px-4">
            <div class="col-12 col-sm-9">
                <input type="text" id="dni" class="form-control p-3"
                    placeholder="Ingrese el DNI o nombre del estudiante | DNI del padre" name="txtdni">
            </div>
            <button id="buscar" class="btn btn-success col-12 col-sm-3 mt-2 mt-sm-0" type="submit">Buscar</button>
        </div>
    </form>
    <div class="card-block table-responsive">
        <table id="" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>DNI</th>
                    <th>Estudiante</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Padre de familia</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tbody">

            </tbody>
        </table>
    </div>


    <div class="pb-1 pt-2 d-flex flex-wrap gap-2">

        <a href="" data-toggle="modal" data-target="#registroMasivo" class="btn btn-rounded btn-primary"><i
                class="fas fa-folder-plus"></i>&nbsp;
            Registro Masivo</a>

        <a href="" data-toggle="modal" data-target="#registrar" class="btn btn-rounded btn-secondary"><i
                class="fas fa-plus"></i>&nbsp;
            Registro manual</a>

        <a href="{{ route('estudiantes.exportarEstudiantes') }}" class="btn btn-rounded btn-success"><i
                class="fas fa-file-excel"></i>&nbsp;
            Exportar a Excel</a>

        <a href="{{ route('estudiantes.vacearRegistro') }}" onclick="return confimar_eliminar()"
            class="btn btn-rounded btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;
            Eliminar todos los registros</a>
    </div>

    @error('txtfile')
        <p class="alert alert-danger p-2">{{ $message }}</p>
    @enderror

    <!-- Modal registrar datos usuario-->
    <div class="modal fade" id="registrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Registrar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('estudiantes.store') }}" method="POST">
                        @csrf

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="number" placeholder="DNI del estudiante" class="input input__text"
                                name="txtdni" value="{{ old('txtdni') }}">
                            @error('txtdni')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>
                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Nombres del estudiante" class="input input__text"
                                name="txtnombre" value="{{ old('txtnombre') }}">
                            @error('txtnombre')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>
                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Apellido Paterno" class="input input__text"
                                name="txtapellidopaterno" value="{{ old('txtapellidopaterno') }}">
                            @error('txtapellidopaterno')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>
                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Apellido Materno" class="input input__text"
                                name="txtapellidomaterno" value="{{ old('txtapellidomaterno') }}">
                            @error('txtapellidomaterno')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div>
                            <label class="font-weight-bold">Padre de familia</label>
                            <div class="fl-flex-label mb-4 px-2 col-12">
                                <select required class="input input__select" name="txtpadrefamilia">
                                    <option value="" disabled selected hidden>Selecciona una opción... *</option>
                                    @foreach ($padreFamilia as $item)
                                        <option value="{{ $item->id_padre_familia }}">
                                            {{ $item->padre_ape_pat . ' ' . $item->padre_ape_mat . ' ' . $item->padre_nombres . ' - ' . $item->padre_dni }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('txtpadrefamilia')
                                    <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                @enderror
                            </div>
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

    <!-- Modal registrar datos usuario masivo-->
    <div class="modal fade" id="registroMasivo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Registrar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('estudiantes.importarEstudiantes') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-primary mb-1" role="alert">
                            <strong>Importante:</strong> Primero descargar el formato y luego cargar.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-primary" role="alert">
                            <strong>Importante:</strong> Asegúrate de no tener datos duplicados en el registro Excel.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        {{-- acceder a storage desde asset --}}

                        <a href="{{ asset('../storage/app/public/ARCHIVOS/estudiante/modeloEstudiante.xlsx') }}"
                            download="" class="btn btn-success"><i class="fas fa-file-excel"></i>
                            Descargar Formato</a>

                        <label class="mt-3"><b>Seleccionar archivo Excel</b></label>
                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="file" class="input input__text" name="txtfile"
                                value="{{ old('txtfile') }}" accept=".xlxs, .xlsx, .xls, .csv">
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
            <table id="example2" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>Id</th>
                        <th>DNI</th>
                        <th>Estudiante</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Padre de familia</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($datosEstudiante as $item)
                        <tr>
                            <td>{{ $item->id_estudiante }}</td>
                            <td>{{ $item->dni }}</td>
                            <td>{{ $item->nombres }}</td>
                            <td>{{ $item->ape_pat }}</td>
                            <td>{{ $item->ape_mat }}</td>
                            <td>{{ $item->padre_dni . ' - ' . $item->padre_nombres . ' - ' . $item->padre_ape_pat . ' - ' . $item->padre_ape_mat }}
                            </td>

                            <td>
                                <a style="top: 0" href="" data-toggle="modal"
                                    data-target="#modificar{{ $item->id_estudiante }}"
                                    class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('estudiantes.destroy', $item->id_estudiante) }}" method="POST"
                                    class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-sm btn-danger eliminar"
                                    data-id="{{ $item->id_estudiante }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>


                            <!-- Modal modificar datos usuario-->
                            <div class="modal fade" id="modificar{{ $item->id_estudiante }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-between">
                                            <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Estudiante</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('estudiantes.update', $item->id_estudiante) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                                    <input type="text" placeholder="ID" class="input input__text"
                                                        name="txtid" value="{{ $item->id_estudiante }}">
                                                </div>
                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="DNI del estudiante"
                                                        class="input input__text" name="txtdni"
                                                        value="{{ $item->dni }}">
                                                </div>
                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Nombres del estudiante"
                                                        class="input input__text" name="txtnombre"
                                                        value="{{ $item->nombres }}">
                                                </div>
                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Apellido Paterno"
                                                        class="input input__text" name="txtapellidopaterno"
                                                        value="{{ $item->ape_pat }}">
                                                </div>
                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Apellido Materno"
                                                        class="input input__text" name="txtapellidomaterno"
                                                        value="{{ $item->ape_mat }}">
                                                </div>

                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <select required class="input input__select" name="txtpadrefamilia">
                                                        <option value="">Selecciona una
                                                            opción... *</option>
                                                        @foreach ($padreFamilia as $itemPadre)
                                                            <option
                                                                {{ $item->id_padre_familia == $itemPadre->id_padre_familia ? 'selected' : '' }}
                                                                value="{{ $itemPadre->id_padre_familia }}">
                                                                {{ $itemPadre->padre_ape_pat . ' ' . $itemPadre->padre_ape_mat . ' ' . $itemPadre->padre_nombres . ' - ' . $itemPadre->padre_dni }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    @error('txtpadrefamilia')
                                                        <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                                                    @enderror
                                                </div>


                                                <div class="text-right p-2">
                                                    <a data-dismiss="modal"
                                                        class="btn btn-secondary btn-rounded">Atras</a>
                                                    <button type="submit" value="ok" name="btnmodificar"
                                                        class="btn btn-primary btn-rounded">Modificar</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                {{ $datosEstudiante->links('pagination::bootstrap-4') }}
                Mostrando {{ $datosEstudiante->firstItem() }} - {{ $datosEstudiante->lastItem() }} de
                {{ $datosEstudiante->total() }}
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


        //enviando datos para la busqueda por ajax
        let formBuscar = document.getElementById("formBuscar");
        let dni = document.getElementById("dni");
        formBuscar.addEventListener("submit", buscarDatos);
        formBuscar.addEventListener("blur", buscarDatos);
        formBuscar.addEventListener("keyup", buscarDatos);
        //dni.addEventListener("blur", buscarDatos);
        //dni.addEventListener("keyup", buscarDatos);

        function buscarDatos(ev) {
            ev.preventDefault();
            let datos = $(this).serialize();
            $.ajax({
                url: "{{ route('estudiantes.buscarEstudiante') }}",
                type: "post",
                data: datos,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Hola correcto " + response.data)
                    let tbody = document.getElementById("tbody")
                    let tr = "";
                    response.data.forEach(function(item, index) {
                        tr +=
                            `
                        <tr>
                            <td>${item.id_estudiante}</td>
                            <td>${item.dni}</td>
                            <td>${item.nombres}</td>
                            <td>${item.ape_pat}</td>
                            <td>${item.ape_mat}</td>
                            <td>${item.padre_dni + ' - ' + item.padre_nombres + ' - ' + item.padre_ape_pat + ' - ' + item.padre_ape_mat}</td>
                            <td>
                                <a style="top: 0" href="estudiantes/${item.id_estudiante}" class="btn btn-sm btn-primary m-1"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        `
                    });
                    tbody.innerHTML = tr
                },
                error: function(error) {
                    let tbody = document.getElementById("tbody")
                    tbody.innerHTML = ""
                }
            });
        }
    </script>

@endsection
