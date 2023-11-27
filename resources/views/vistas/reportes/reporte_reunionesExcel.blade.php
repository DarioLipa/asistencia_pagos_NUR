<!DOCTYPE html>
<html>

<head>
    <title>Reporte de reuniones en excel</title>
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="page">
        <table>
            <thead>
                <tr>
                    <td colspan="7">
                        @foreach ($tituloAporte as $item)
                            {{ strtoupper($item->titulo) }}
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td colspan="7" class="titulo pagado">LISTA DE PADRES DE FAMILIA</td>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Padre de familia</th>
                    <th>Reunion</th>
                    <th>Fecha de la reunión</th>
                    <th>Multa</th>
                    <th>Asistencia</th>
                    <th>Estado</th>
                </tr>
            </thead>
            @foreach ($datos as $key => $item)
                @if ($item->asistencia == null and $item->detalles == null)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->fecha }} {{ $item->hora }}</td>
                        <td>S/. {{ $item->multa_precio }}</td>
                        <td>Faltó</td>
                        <td>❌</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->fecha }} {{ $item->hora }}</td>
                        <td>S/. {{ $item->multa_precio }}</td>
                        <td>{{ $item->asistencia }} {{ $item->detalles }}</td>
                        <td>✔</td>
                    </tr>
                @endif
            @endforeach
        </table>



    </div>
</body>

</html>
