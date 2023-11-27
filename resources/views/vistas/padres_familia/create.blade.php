@extends('layouts.app')
@section('titulo', 'Registro de padres de familia')
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

    <h4 class="text-center text-secondary">REGISTRO DE PADRES DE FAMILIA</h4>

    <div class="mb-0 col-12 bg-white p-5 pt-4">
        <div class="text-center alert alert-dark font-weight-bold">Registro manual</div>
        <form action="{{ route('padres-familia.store') }}" method="POST" id="form2">
            @csrf

            {{-- hacer un select para el cargo --}}
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select name="txtcargo" class="input input__select">
                    <option value="">Seleccione Cargo</option>
                    @foreach ($cargo as $item)
                        <option {{ old('txtcargo') == $item->id_cargo ? 'selected' : '' }} value="{{ $item->id_cargo }}">
                            {{ $item->nombre }}</option>
                    @endforeach
                </select>
                @error('txtcargo')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select name="txtconsanguinidad" class="input input__select">
                    <option value="">Seleccione Consanguinidad</option>
                    @foreach ($consanguinidad as $item)
                        <option {{ old('txtconsanguinidad') == $item->id_tipo_consanguinidad ? 'selected' : '' }}
                            value="{{ $item->id_tipo_consanguinidad }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
                @error('txtconsanguinidad')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txtdni" class="input input__text" placeholder="DNI *"
                    value="{{ old('txtdni') }}">
                @error('txtdni')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txtnombre" class="input input__text" placeholder="Nombres *"
                    value="{{ old('txtnombre') }}">
                @error('txtnombre')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txtapellidopaterno" class="input input__text" placeholder="Apellido paterno *"
                    value="{{ old('txtapellidopaterno') }}">
                @error('txtapellidopaterno')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txtapellidomaterno" class="input input__text" placeholder="Apellido materno *"
                    value="{{ old('txtapellidomaterno') }}">
                @error('txtapellidomaterno')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>


            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txttelefono" class="input input__text" id="telefono" placeholder="Telefono"
                    value="{{ old('txttelefono') }}">
                @error('txttelefono')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="txtdireccion" class="input input__text" id="direccion"
                    placeholder="Direccion donde vive" value="{{ old('txtdireccion') }}">
                @error('txtdireccion')
                    <small class="error error__text">{{ $message }}</small>
                @enderror
            </div>



            <div class="text-right mt-0">
                <a href="{{ route('padres-familia.index') }}" class="btn btn-secondary btn-rounded">Atras</a>
                <button form="form2" type="submit" class="btn btn-rounded btn-primary">Registrar Datos</button>
            </div>

        </form>
    </div>

    <div class="mb-0 col-12 bg-white p-5 pt-0">
        <div class="text-center alert alert-dark font-weight-bold">Registro masivo</div>
        <form action="{{ route('padres-familia.importarPadresFamilia') }}" method="POST" enctype="multipart/form-data">
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

            <a href="{{ route('padres-familia.exportarPadresFamiliaModelo') }}" class="btn btn-success"><i
                    class="fas fa-file-excel"></i>
                Descargar Formato</a>

            <a href="{{ asset('../storage/app/public/ARCHIVOS/padre de familia/MODELO.png') }}" target="_blank" class="btn btn-secondary"><i
                    class="fas fa-file-image"></i>
                Guíate con esta imagen</a>

            <label class="mt-3"><b>Seleccionar archivo Excel</b></label>
            <div class="fl-flex-label mb-4 px-2 col-12">
                <input required type="file" class="input input__text" name="txtfile" value="{{ old('txtfile') }}"
                    accept=".xlxs, .xlsx, .xls, .csv">
            </div>

            <div class="text-right p-2">
                <a href="{{ route('padres-familia.index') }}" class="btn btn-secondary btn-rounded">Atras</a>
                <button type="submit" value="ok" name="btnmodificar" class="btn btn-primary btn-rounded">Registrar
                    Datos</button>
            </div>
        </form>
    </div>
@endsection
