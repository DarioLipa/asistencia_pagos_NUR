<!DOCTYPE html>
<html>

<head>
    <title>Reporte de aportes</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            font-size: 11px;
            width: 100%;
            margin-bottom: 20px;
        }

        td,
        th {
            border: 1px solid rgb(211, 211, 211);
            padding: 3px 10px;
            margin: 0;
        }

        .titulo {
            text-align: center;
            font-weight: bold;
            background: rgb(215, 215, 215);
        }

        .pagado {
            background: rgb(187, 255, 187);
        }

        .debe {
            background: rgb(255, 153, 153);
        }

        .tituloPrincipal {
            text-align: center;
            background: rgb(217, 218, 217);
            font-size: 16px;
            padding: 10px;
            margin: 0;
            font-weight: bold;
        }

        thead {
            position: fixed;
        }
    </style>
</head>

<body>

    <div class="page">
        <table>
            <thead>
                <tr>
                    <td colspan="6" class="tituloPrincipal">
                        @foreach ($tituloReunion as $item)
                            {{ strtoupper($item->titulo) }}
                        @endforeach
                    </td>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td colspan="6" class="titulo pagado">LISTA DE PADRES DE FAMILIA ASISTIDOS</td>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Padre de familia</th>
                    <th>Reunión</th>
                    <th>Fecha de la reunion</th>
                    <th>Multa</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            @foreach ($padresAsistidos as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                    <td>{{ $item->titulo }}</td>
                    <td>{{ $item->fecha }} {{ $item->hora }}</td>
                    <td>S/. {{ $item->multa_precio }}</td>
                    <td>{{ $item->asistencia }} {{ $item->detalles }}</td>
                </tr>
            @endforeach
            <thead>
                <tr>
                    <td colspan="6" class="titulo debe">LISTA DE PADRES DE FAMILIA QUE FALTARON</td>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Padre de familia</th>
                    <th>Reunión</th>
                    <th>Fecha de la reunion</th>
                    <th>Multa</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            @foreach ($padresNoAsistidos as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->padre_ape_pat }} {{ $item->padre_ape_mat }} {{ $item->padre_nombres }} </td>
                    <td>{{ $item->titulo }}</td>
                    <td>{{ $item->fecha }} {{ $item->hora }}</td>
                    <td>S/. {{ $item->multa_precio }}</td>
                    <td>Falta</td>
                </tr>
            @endforeach

            <br>

            {{-- suma total no adeudados --}}
            @foreach ($sumaTotalNoAdeudados as $item)
                <tr>
                    <td colspan="4"><b>Suma total noAdeudados</b></td>
                    <td colspan="2">S/. {{ $item->sumaTotalNoAdeudados }}</td>
                </tr>
            @endforeach

            {{-- suma total adeudados --}}
            @foreach ($sumaTotalAdeudados as $item)
                <tr>
                    <td colspan="4"><b>Suma total adeudados</b></td>
                    <td colspan="2">S/. {{ $item->sumaTotalAdeudados }}</td>
                </tr>
            @endforeach

            {{-- suma total --}}

            <tr>
                <td colspan="4"><b>Suma total</b></td>
                <td colspan="2">S/. {{ $sumaTotal }}</td>
            </tr>



    </div>
</body>

</html>
