@extends('layouts.app')
@section('titulo', 'Datos del estudiante')
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

    <script>
        function confimar_eliminar(params) {
            var res = confirm("estas seguro que deseas eliminar");
            return res;
        }
    </script>

    <h4 class="text-center text-secondary">DATOS DEL ESTUDIANTE</h4>

    <div class="mb-0 col-12 bg-white p-5 pt-4">
        @foreach ($datosEstudiante as $item)
            <form action="{{ route('estudiantes.update', $item->id_estudiante) }}" method="POST" id="form2">
                @method('PUT')
                @csrf
                <div class="row">
                    <input type="hidden" name="txtid" value="{{ $item->id_estudiante }}">

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtdni" class="input input__text" placeholder="DNI *"
                            value="{{ old('txtdni', $item->dni) }}">
                        @error('txtdni')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtnombre" class="input input__text" id="nombre"
                            placeholder="Nombre *" value="{{ old('txtnombre', $item->nombres) }}">
                        @error('txtnombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtapellidopaterno" class="input input__text"
                            placeholder="Apellido Paterno *" value="{{ old('txtapellidopaterno', $item->ape_pat) }}">
                        @error('txtapellidopaterno')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtapellidomaterno" class="input input__text"
                            placeholder="Apellido Materno *" value="{{ old('txtapellidomaterno', $item->ape_mat) }}">
                        @error('txtapellidomaterno')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 px-2 col-12">
                        <select required class="input input__select" name="txtpadrefamilia">
                            <option value="" disabled selected hidden>Selecciona una opción... *</option>
                            @foreach ($datosPadreFamilia as $item2)
                                <option {{ $item2->id_padre_familia == $item->id_padre_familia ? 'selected' : '' }}
                                    value="{{ $item2->id_padre_familia }}">
                                    {{ $item2->padre_ape_pat . ' ' . $item2->padre_ape_mat . ' ' . $item2->padre_nombres . ' - ' . $item2->padre_dni }}
                                </option>
                            @endforeach
                        </select>

                        @error('txtpadrefamilia')
                            <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                        @enderror
                    </div>
                </div>
            </form>

            <div class="text-right mt-0">
                <a href="{{ route('estudiantes.index') }}" class="btn btn-rounded btn-secondary">Atras</a>

                <form action="{{ route('estudiantes.destroy', $item->id_estudiante) }}" method="POST"
                    class="d-inline formulario-eliminar">
                    @csrf
                    @method('delete')
                </form>
                <a href="#" class="btn btn-rounded btn-danger eliminar" data-id="{{ $item->id_estudiante }}">
                    Eliminar
                </a>
                <button form="form2" type="submit" class="btn btn-rounded btn-primary">Modificar Datos</button>
            </div>

        @endforeach
    </div>
@endsection
