@extends('layouts/app')
@section('titulo', 'Reuniones')
@section('content')

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

    <h4 class="text-center text-secondary">AGREGA PARTICIPANTES A LA REUNIÓN</h4>

    <div class="modal-body">
        <form action="{{ route('reuniones.addParticipante') }}" method="POST" id="form">
            @csrf
            @foreach ($reunion as $itemReunion)
                <div class="text-right p-2">
                    <button type="button" id="btnGuardarSalir" class="btn btn-success"><i class="fas fa-save"></i>
                        Agregar</button>
                    <a href="{{ route('reuniones.eliminarParticipante', $itemReunion->id_reunion) }}"
                        onclick="return confimar_eliminar()" class="btn btn-danger"><i class="fas fa-times"></i>
                        Eliminar todo</a>
                </div>
                <input type="hidden" name="txtidparticipante" id="txtidparticipante">
                <input type="hidden" name="txtidreunion" value="{{ $itemReunion->id_reunion }}">
                <div class="alert alert-success font-weight-bold p-2">{{ $itemReunion->titulo }}
                </div>
            @endforeach
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>Todos <input type="checkbox" class="form form-check select-all" id="todos">
                        </th>
                        <th>DNI</th>
                        <th>Cargo</th>
                        <th>Nombre del padre de familia</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($padresFamilia as $item)
                        <tr>
                            <td>
                                @if ($item->esta_vinculado_en_reunion == 'si')
                                    <input checked type="checkbox" data-idparticipante="{{ $item->id_padre_familia }}"
                                        class="form-check select-item">
                                @else
                                    <input type="checkbox" data-idparticipante="{{ $item->id_padre_familia }}"
                                        class="form-check select-item">
                                @endif

                            </td>
                            <td>{{ $item->padre_dni }}</td>
                            <td>{{ $item->cargo }}</td>
                            <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }}
                                {{ $item->padre_nombres }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

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

    <script>
        $('#btnGuardarSalir').click(function(e) {
            e.preventDefault(); // Evitar el envío predeterminado del formulario

            // Obtener los ID de los participantes seleccionados
            var selectedParticipants = [];

            // Obtener los ID de los participantes seleccionados en la página actual
            $('.select-item:checked').each(function() {
                var idParticipante = $(this).data('idparticipante');
                if (!selectedParticipants.includes(idParticipante)) {
                    selectedParticipants.push(idParticipante);
                }
            });

            // Acceder a los datos de todas las páginas a través de DataTables API
            var table = $('#example').DataTable();
            table.$('.select-item:checked').each(function() {
                var idParticipante = $(this).data('idparticipante');
                if (!selectedParticipants.includes(idParticipante)) {
                    selectedParticipants.push(idParticipante);
                }
            });

            // Establecer los ID de los participantes en el campo oculto del formulario
            $('#txtidparticipante').val(selectedParticipants.join(','));
            console.log(selectedParticipants.join(',') + ' participantes seleccionados');
            // Enviar el formulario
            $('#form').submit();
        });
    </script>

@endsection
