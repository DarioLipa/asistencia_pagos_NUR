@extends('layouts/app')
@section('titulo', 'Mi perfil')

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

    @if (session('AVISO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "AVISO",
                    type: "error",
                    text: "{{ session('AVISO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif


    <h4 class="text-center text-secondary">MI PERFIL</h4>

    <div class="mb-0 col-12 bg-white p-5 pt-0">
        @foreach ($sql as $item)
           
            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" name="id" value="{{ $item->id_usuario }}">

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtnombre" class="input input__text" id="nombre" placeholder="Nombre"
                            value="{{ old('txtnombre', $item->nombres) }}">
                        @error('txtnombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="txtusuario" class="input input__text" placeholder="Usuario *"
                            value="{{ old('txtusuario', $item->usuario) }}">
                        @error('txtusuario')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="email" name="txtcorreo" class="input input__text" placeholder="Correo *"
                            value="{{ old('correo', $item->correo) }}">
                    </div>

                    <div class="text-right mt-0">
                        <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
        @endforeach
    </div>




@endsection
