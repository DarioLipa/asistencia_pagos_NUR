<!DOCTYPE html>
<html>

<head>
    <title>Reporte de aportes en excel</title>
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
                    <th>Nombre aporte</th>
                    <th>Monto aporte</th>
                    <th>Monto aportado</th>
                    <th>Debe</th>
                    <th>Estado</th>
                </tr>
            </thead>
            @foreach ($datos as $key => $item)
                @if (($item->debe == null) | ($item->debe > 0))
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                        <td>{{ $item->titulo }}</td>
                        <td>S/. {{ $item->monto_aporte }}</td>
                        <td>S/. {{ $item->monto_aportado }}</td>
                        <td>--</td>
                        <td>❌</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                        <td>{{ $item->titulo }}</td>
                        <td>S/. {{ $item->monto_aporte }}</td>
                        <td>S/. {{ $item->monto_aportado }}</td>
                        <td>S/. {{ $item->monto_aporte - $item->monto_aportado }}</td>
                        <td>✔</td>
                    </tr>
                @endif
            @endforeach
        </table>



    </div>
</body>

</html>
