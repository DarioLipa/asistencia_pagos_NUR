@extends('layouts/app')
@section('titulo', 'Lista de padres de familia')
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

    <h4 class="text-center text-secondary">LISTA DE LOS PADRES DE FAMILIA</h4>

    <form action="#" id="formBuscar">
        <div class="form-group row col-12 px-4">
            <div class="col-12 col-sm-9">
                <input type="text" id="dni" class="form-control p-3"
                    placeholder="Ingrese el DNI o nombre del padre de familia" name="txtdni">
            </div>
            <button id="buscar" class="btn btn-success col-12 col-sm-3 mt-2 mt-sm-0" type="submit">Buscar</button>
        </div>
    </form>
    <div class="card-block table-responsive">
        <table id="" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>Cargo</th>
                    <th>Tipo consanguinidad</th>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Celular</th>
                    <th>Direccion</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tbody">

            </tbody>
        </table>
    </div>


    <div class="pb-1 pt-2 d-flex flex-wrap gap-2">

        {{-- <a href="" data-toggle="modal" data-target="#registroMasivo" class="btn btn-rounded btn-primary"><i
                class="fas fa-folder-plus"></i>&nbsp;
            Registro Masivo</a> --}}

        <a href="{{ route('padres-familia.create') }}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Registro de padres</a>

        <a href="{{ route('padres-familia.exportarPadresFamilia') }}" class="btn btn-rounded btn-success"><i
                class="fas fa-file-excel"></i>&nbsp;
            Exportar a Excel</a>

        <a href="{{ route('padres-familia.vacearRegistro') }}" onclick="return confimar_eliminar()"
            class="btn btn-rounded btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;
            Eliminar todos los registros</a>
        <a href="{{ route('padres-familia.descargarTarjeta', ['pagina' => $datosPadreFamilia->currentPage()]) }}" target="_blank" class="btn btn-rounded btn-secondary"><i class="fas fa-file-pdf"></i>&nbsp;
            Descargar tarjeta de Pag {{ $datosPadreFamilia->firstItem() }} - {{ $datosPadreFamilia->lastItem() }} </a>
    </div>

    @error('txtfile')
        <p class="alert alert-danger p-2">{{ $message }}</p>
    @enderror


    @if (session('AVISO'))
        <div class="alert bg-danger mb-1">
            {{ session('AVISO') }}
        </div>
    @endif

    <section class="card">
        <div class="card-block">
            <table id="example2" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>Id</th>
                        <th>DNI</th>
                        <th>Cargo</th>
                        <th>Tipo consanguinidad</th>
                        <th>Nombres</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($datosPadreFamilia as $item)
                        <tr>

                            <td>{{ $item->id_padre_familia }}</td>
                            <td>{{ $item->padre_dni }}</td>
                            <td>{{ $item->cargo }}</td>
                            <td>{{ $item->tipo_consanguinidad }}</td>
                            <td>{{ $item->padre_nombres }}</td>
                            <td>{{ $item->padre_ape_pat }}</td>
                            <td>{{ $item->padre_ape_mat }}</td>
                            <td>{{ $item->celular }}</td>
                            <td>{{ $item->direccion }}</td>


                            <td>
                                <a style="top: 0" href="{{ route('padres-familia.show', $item->id_padre_familia) }}"
                                    class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('padres-familia.destroy', $item->id_padre_familia) }}"
                                    method="POST" class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-sm btn-danger eliminar"
                                    data-id="{{ $item->id_padre_familia }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a style="top: 0" target="_blank"
                                    href="{{ route('padres-familia.tarjeta', $item->id_padre_familia) }}"
                                    class="btn btn-sm bg-primary m-1" title="Generar tarjeta"><i
                                        class="fas fa-address-card"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                {{ $datosPadreFamilia->links('pagination::bootstrap-4') }}
                Mostrando {{ $datosPadreFamilia->firstItem() }} - {{ $datosPadreFamilia->lastItem() }} de
                {{ $datosPadreFamilia->total() }}
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
                url: "{{ route('padres-familia.buscarPadreFamilia') }}",
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
                            <td>${item.id_padre_familia}</td>
                            <td>${item.cargo}</td>
                            <td>${item.tipo_consanguinidad}</td>
                            <td>${item.padre_dni}</td>
                            <td>${item.padre_nombres}</td>
                            <td>${item.padre_ape_pat}</td>
                            <td>${item.padre_ape_mat}</td>
                            <td>${item.celular}</td>
                            <td>${item.direccion}</td>
                            <td>
                                <a style="top: 0" href="padres-familia/${item.id_padre_familia}" class="btn btn-sm btn-primary m-1"><i class="fas fa-eye"></i></a>
                                <a style="top: 0" href="padres-familia-tarjeta-${item.id_padre_familia}" target="_blank" class="btn btn-sm bg-primary m-1"title="Generar tarjeta"><i class="fas fa-address-card"></i></a>
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
