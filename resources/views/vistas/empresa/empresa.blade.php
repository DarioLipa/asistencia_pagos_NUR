@extends('layouts/app')
@section('titulo', 'empresa')
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

    <h4 class="text-center text-secondary">DATOS DE LA EMPRESA</h4>



    <div class="mb-0 col-12 bg-white p-5">

        @foreach ($sql as $item)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">LOGO DE LA INSTITUCIÓN</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">LOGO DE LA UGEL</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="d-flex justify-content-around align-items-center flex-wrap gap-5 pt-5 pb-3 mb-3 img">
                        <div class="text-center">
                            @if ($item->foto_institucion == null)
                                <p class="logo" style="font-size: 100px">
                                    <i class="far fa-frown"></i>
                                </p>
                            @else
                                <img width="200px" class="logo"
                                    src="{{ asset("storage/ARCHIVOS/empresa/$item->foto_institucion") }}" alt="">
                            @endif
                        </div>
                        <div>
                            <h6 class="text-dark font-weight-bold">Modificar imagen</h6>
                            <form action="{{ route('empresa.subirImgInstitucion') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="alert alert-secondary">Selecciona una imagen no muy <b>pesado</b> y en un
                                    formato
                                    <b>válido</b> ...!
                                </div>
                                <div class="fl-flex-label mb-4 col-12">
                                    <input required type="file" name="foto" class="input form-control-file input__text"
                                        value="" accept=".jpg, .png, .jpeg">
                                    @error('foto')
                                        <small class="error error__text">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end gap-4">
                                    <div class="text-right mt-0">
                                        <button type="submit" class="btn btn-rounded btn-success"><i
                                                class="fas fa-save"></i>&nbsp;&nbsp; Modificar perfil</button>
                                    </div>
                                    <div class="text-right mt-0">
                                        <a onclick="return funcionEliminar()"
                                            href="{{ route('empresa.eliminarImgInstitucion') }}"
                                            class="btn btn-rounded btn-danger"><i class="fas fa-trash"></i>&nbsp;&nbsp;
                                            Eliminar
                                            foto</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="d-flex justify-content-around align-items-center flex-wrap gap-5 pt-5 pb-3 mb-3 img">
                        <div class="text-center">
                            @if ($item->foto_ugel == null)
                                <p class="logo" style="font-size: 100px">
                                    <i class="far fa-frown"></i>
                                </p>
                            @else
                                <img width="200px" class="logo" src="{{ asset("storage/ARCHIVOS/empresa/$item->foto_ugel") }}"
                                    alt="">
                            @endif
                        </div>
                        <div>
                            <h6 class="text-dark font-weight-bold">Modificar imagen</h6>
                            <form action="{{ route('empresa.subirImgUgel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="alert alert-secondary">Selecciona una imagen no muy <b>pesado</b> y en un
                                    formato
                                    <b>válido</b> ...!
                                </div>
                                <div class="fl-flex-label mb-4 col-12">
                                    <input required type="file" name="fotoUgel" class="input form-control-file input__text"
                                        value="" accept=".jpg, .png, .jpeg">
                                    @error('fotoUgel')
                                        <small class="error error__text">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end gap-4">
                                    <div class="text-right mt-0">
                                        <button type="submit" class="btn btn-rounded btn-success"><i
                                                class="fas fa-save"></i>&nbsp;&nbsp; Modificar perfil</button>
                                    </div>
                                    <div class="text-right mt-0">
                                        <a onclick="return funcionEliminar()" href="{{ route('empresa.eliminarImgUgel') }}"
                                            class="btn btn-rounded btn-danger"><i class="fas fa-trash"></i>&nbsp;&nbsp;
                                            Eliminar
                                            foto</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('empresa.update', $item->id_empresa) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="nombre" class="input input__text" id="nombre"
                            placeholder="Nombre" value="{{ $item->nombre }}">
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="cod_modular" class="input input__text" id="cod_modular"
                            placeholder="cod_modular" value="{{ $item->cod_modular }}">
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="telefono" class="input input__text" id="telefono"
                            placeholder="telefono" value="{{ $item->telefono }}">

                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="ubicacion" class="input input__text" placeholder="ubicacion *"
                            value="{{ old('ubicacion', $item->ubicacion) }}">

                    </div>



                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="correo" class="input input__text" placeholder="correo *"
                            value="{{ old('correo', $item->correo) }}">

                    </div>

                    <div class="text-right mt-0">
                        <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
        @endforeach
    </div>

    <script>
        function funcionEliminar() {
            return confirm("¿Estas seguro de eliminar...?")
        }
    </script>

@endsection
