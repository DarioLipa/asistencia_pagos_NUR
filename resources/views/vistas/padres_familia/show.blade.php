@extends('layouts.app')
@section('titulo', 'Datos del padre de familia')
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

    <h4 class="text-center text-secondary">DATOS DEL PADRE DE FAMILIA</h4>

    <div class="mb-0 col-12 bg-white p-5 pt-4">
        @foreach ($datosPadreFamilia as $item)
            <form action="{{ route('padres-familia.update', $item->id_padre_familia) }}" method="POST" id="form2">
                @method('PUT')
                @csrf
                <div class="row">
                    <input type="hidden" name="txtid" value="{{ $item->id_padre_familia }}">

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtdni" class="input input__text" placeholder="DNI *"
                            value="{{ old('txtdni', $item->padre_dni) }}">
                        @error('txtdni')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtnombre" class="input input__text" id="nombre"
                            placeholder="Nombre *" value="{{ old('txtnombre', $item->padre_nombres) }}">
                        @error('txtnombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtapellidopaterno" class="input input__text"
                            placeholder="Apellido Paterno *" value="{{ old('txtapellidopaterno', $item->padre_ape_pat) }}">
                        @error('txtapellidopaterno')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtapellidomaterno" class="input input__text"
                            placeholder="Apellido Materno *" value="{{ old('txtapellidomaterno', $item->padre_ape_mat) }}">
                        @error('txtapellidomaterno')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtcelular" class="input input__text" placeholder="Celular"
                            value="{{ old('txtcelular', $item->celular) }}">
                        @error('txtcelular')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtdireccion" class="input input__text" placeholder="Direccion"
                            value="{{ old('txtdireccion', $item->direccion) }}">
                        @error('txtdireccion')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <select required class="input input__select" name="txtcargo">
                            <option value="">Selecciona una opción... *</option>
                            @foreach ($cargo as $item2)
                                <option {{ $item2->id_cargo == $item->id_cargo ? 'selected' : '' }}
                                    value="{{ $item2->id_cargo }}">
                                    {{ $item2->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('txtcargo')
                            <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <select required class="input input__select" name="txtconsanguinidad">
                            <option value="">Selecciona una opción... *</option>
                            @foreach ($consanguinidad as $item3)
                                <option
                                    {{ $item3->id_tipo_consanguinidad == $item->tipo_consanguinidad ? 'selected' : '' }}
                                    value="{{ $item3->id_tipo_consanguinidad }}">
                                    {{ $item3->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('txtconsanguinidad')
                            <p class="error-message text-danger p-2">Este campo es obligatorio</p>
                        @enderror
                    </div>

                </div>
            </form>

            <div class="mb-0 col-12 bg-light p-5 pt-4">
                <h6 class="text-center text-secondary font-weight-bold">ESTUDIANTES A CARGO</h6>
                <ol>
                    @foreach ($estudiantesACargo as $item)
                        <li class="text-dark">{{ $item->nombres }} {{ $item->ape_pat }} {{ $item->ape_mat }}</li>
                    @endforeach
                </ol>
            </div>

            <div class="text-right mt-0">
                <a href="{{ route('padres-familia.index') }}" class="btn btn-rounded btn-secondary">Atras</a>

                <form action="{{ route('padres-familia.destroy', $item->id_padre_familia) }}" method="POST"
                    class="d-inline formulario-eliminar">
                    @csrf
                    @method('delete')
                </form>
                <a href="#" class="btn btn-rounded btn-danger eliminar" data-id="{{ $item->id_padre_familia }}">
                    Eliminar
                </a>
                <button form="form2" type="submit" class="btn btn-rounded btn-primary">Modificar Datos</button>
            </div>
        @endforeach


    </div>
@endsection
