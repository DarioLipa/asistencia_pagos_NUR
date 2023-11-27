@extends('layouts/app')
@section('titulo', 'Usuarios')
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

    <h4 class="text-center text-secondary">LISTA DE USUARIOS</h4>



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
                    <h5 class="modal-title w-100" id="exampleModalLabel">Registrar Cargo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Nombres del usuario" class="input input__text"
                                name="txtnombre" value="{{ old('txtnombre') }}">
                            @error('txtnombre')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Usuario" class="input input__text" name="txtusuario"
                                value="{{ old('txtusuario') }}">
                            @error('txtusuario')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="password" placeholder="Contraseña" class="input input__text"
                                name="txtclave" value="{{ old('txtclave') }}">
                            @error('txtclave')
                                <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                            @enderror
                        </div>

                        <div class="fl-flex-label mb-4 px-2 col-12">
                            <input required type="text" placeholder="Correo" class="input input__text" name="txtcorreo"
                                value="{{ old('txtcorreo') }}">
                            @error('txtcorreo')
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
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuarios as $item)
                        <tr>
                            <td>{{ $item->id_usuario }}</td>
                            <td>{{ $item->nombres }}</td>
                            <td>{{ $item->usuario }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>
                                <a style="top: 0" href="" data-toggle="modal"
                                    data-target="#modificar{{ $item->id_usuario }}" class="btn btn-sm btn-warning m-1"><i
                                        class="fas fa-edit"></i></a>

                                <form action="{{ route('usuarios.destroy', $item->id_usuario) }}" method="POST"
                                    class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-sm btn-danger eliminar" data-id="{{ $item->id_usuario }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>


                            <!-- Modal modificar datos usuario-->
                            <div class="modal fade" id="modificar{{ $item->id_usuario }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-between">
                                            <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Usuario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('usuarios.update', $item->id_usuario) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                                    <input type="text" placeholder="ID" class="input input__text"
                                                        name="txtid" value="{{ $item->id_usuario }}">
                                                </div>

                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Nombres del cargo"
                                                        class="input input__text" name="txtnombre"
                                                        value="{{ $item->nombres }}">
                                                </div>

                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Usuario"
                                                        class="input input__text" name="txtusuario"
                                                        value="{{ $item->usuario }}">
                                                </div>


                                                <div class="fl-flex-label mb-4 px-2 col-12">
                                                    <input required type="text" placeholder="Correo"
                                                        class="input input__text" name="txtcorreo"
                                                        value="{{ $item->correo }}">
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
    </script>

@endsection
