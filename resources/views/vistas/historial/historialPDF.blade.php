<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Padres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .nombrePadre {
            padding: 11px;
            background: rgb(171, 182, 186);
            font-size: 12px;
            color: rgb(10, 37, 68);
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-secondary {
            color: #fdfdfd;
            background: rgb(29, 105, 135);
            padding: 10px,
        }

        .card-block {
            margin-bottom: -40px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .title {
            background: rgb(208, 216, 219) !important;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f9f9f9;
        }

        .table2 {
            margin-top: 60px;
        }

        .debe {
            background: rgb(255, 164, 164);
            padding: 5px 10px;
            color: rgb(61, 14, 14);
        }

        .pagado {
            background: rgb(161, 255, 161);
            padding: 5px 10px;
            color: rgb(11, 69, 38);
        }

        .monto__aportado,
        .multa {
            background: black;
            color: white;
            padding: 6px;
            font-weight: bold;
        }
        .monto__aporte{
            background: green;
            padding: 6px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1 class="text-center text-secondary">HISTORIAL DE PADRES</h1>
    <div class="nombrePadre">
        PADRE DE FAMILIA: 
        @foreach ($nombrePadreFamilia as $item)
            {{ $item->nombre }}
        @endforeach
    </div>
    <div class="card-block table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="8" class="text-center bg-info title">APORTES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Monto que debe aportar</th>
                    <th>Monto aportado</th>
                    <th>Monto que debe</th>
                    <th>Fecha plazo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($historialAportes as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->monto }} <b> X {{ $cantidadHijos }} hijos = S/. {{ $item->monto_aporte }}</b>
                        </td>
                        <td><span class="monto__aporte">S/. {{ $item->monto_aportado }}</span></td>
                        <td><span class="monto__aportado">S/. {{ $item->debe }}</span></td>
                        <td>{{ $item->fecha }}</td>
                        <td>
                            @if ($item->debe == null || $item->debe > 0)
                                <span class="debe">Debe</span>
                            @else
                                <span class="pagado">Pagado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-block table-responsive">
        <table class="table table2">
            <thead>
                <tr>
                    <th colspan="6" class="text-center bg-info title">REUNIONES</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Multa</th>
                    <th>Fecha y hora de la reunion</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody id="tbodyreuniones">
                @foreach ($historialReuniones as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td><span class="multa">S/. {{ $item->multa_precio }}</span></td>
                        <td>{{ $item->fecha }} {{ $item->hora }}</td>
                        <td>
                            @if ($item->asistencia == null and ($item->detalles == '' or $item->detalles == null))
                                <span class="debe">Falta</span>
                            @else
                                @if ($item->asistencia != null or $item->asistencia != '')
                                    <span class="pagado">{{ $item->asistencia }}</span>
                                @else
                                    <span class="pagado">{{ $item->detalles }}</span>
                                @endif
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
