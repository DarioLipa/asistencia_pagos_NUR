<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tarjeta APAFA</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    
    body {
        width: 85%;
        margin: auto;
        background: rgb(255, 255, 255);
        font-size: 12px;
        background: rgb(255, 255, 255);
        font-family: 'Roboto', sans-serif;
        padding: 10px;
        position: relative;
        border: 1px solid #000;
    }
    .image img {
        width: 55px;
        position: absolute;
        top: 18;
    }

    .foto__institucion{
        left: 15;
    }

    .foto__ugel {
        right: 15;
    }

    h1 {
        text-align: center;
        padding: 15px 70px;
        background: rgb(5, 46, 84);
        color: rgb(255, 255, 255);
        font-weight: bold;
        margin-bottom: 0;
        margin-top: 0;
        font-size: 25px;
    }

    .nombre__anio {
        background: rgb(7, 70, 129);
        color: white;
        padding: 8px;
        margin-top: 10px;
        font-weight: bold;
        text-align: center;
        font-size: 16px;
    }

    /* estilos de la tabla */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        font-size: 12px;
        background: rgb(236, 246, 255);
    }

    th,
    td {
        border: 0.2px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
    }

    td[colspan="4"],
    td[colspan="5"] {
        text-align: center;
        font-weight: bold;
    }

    td[colspan="2"] {
        text-align: center;
    }

    .title {
        font-weight: bold;
        background: rgba(208, 220, 253, 0.9)
    }

    .container__qr {
        text-align: center;
        position: absolute;
        right: 5;
        bottom: 5
    }

    .container__historial {
        text-align: center;
        position: absolute;
        left: 5;
        bottom: 5
    }

    .qr {
        width: 80px;
    }

    .sello {
        text-align: center;
    }

    .post {
        margin: 0;
        padding: 0;
    }
</style>

<body>
    <div class="card">
        <h1>ASOCIACIÓN DE PADRES DE FAMILIA</h1>
        @foreach ($empresa as $item)
            <div class="image">
                <img class="foto__institucion" src="{{ public_path("storage/ARCHIVOS/empresa/$item->foto_institucion") }}" alt="foto institucion">

                <img class="foto__ugel" src="{{ public_path("storage/ARCHIVOS/empresa/$item->foto_ugel") }}"
                    alt="foto UGEL">
            </div>
        @endforeach
        <div class="content">
            <p class="nombre__anio">TARJETA DE APAFA {{ date('Y') }} --- N° {{ $id_padre }}</p>

            <table>
                @foreach ($empresa as $itemEmpresa)
                    <tbody>
                        <tr>
                            <td colspan="4" class="title">Datos de la I.E</td>
                        </tr>
                        <tr>
                            <td class="title">Cod. modular</td>
                            <td>{{ $itemEmpresa->cod_modular }}</td>
                            <td class="title">Nombre</td>
                            <td>{{ $itemEmpresa->nombre }}</td>
                        </tr>
                        <tr>
                            <td class="title">Ubicación</td>
                            <td>{{ $itemEmpresa->ubicacion }}</td>
                            <td class="title">Teléfono</td>
                            <td>{{ $itemEmpresa->telefono }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>


            <table>
                @foreach ($datosPadreFamilia as $item)
                    <tbody>
                        <tr>
                            <td colspan="4" class="title">Datos del padre de familia</td>
                        </tr>
                        <tr>
                            <td class="title">DNI</td>
                            <td>{{ $item->padre_dni }}</td>
                            <td class="title">Nombres</td>
                            <td>{{ $item->padre_nombres }}</td>
                        </tr>
                        <tr>
                            <td class="title">Apellido paterno</td>
                            <td>{{ $item->padre_ape_pat }}</td>
                            <td class="title">Apellido materno</td>
                            <td>{{ $item->padre_ape_mat }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Direccion: {{ $item->direccion }}</td>
                            <td colspan="2">Celular: {{ $item->celular }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="title">Consanguinidad</td>
                            <td colspan="2">{{ $item->nombre_consanguinidad }}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>

            <table>
                <thead>
                    <tr>
                        <td colspan="5" class="title">Datos del estudiante</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datosEstudiante as $key => $item2)
                        <tr>
                            <td class="title number">{{ $key + 1 }}</td>
                            <td class="title">DNI</td>
                            <td>{{ $item2->dni }}</td>
                            <td class="title">Nombres</td>
                            <td>{{ $item2->nombres }} {{ $item2->ape_pat }} {{ $item2->ape_mat }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <br>
            <br>
            <br><br><br><br>
            <div class="sello">
                <p>---------------------------------------------------------</p>
                <p class="post">Director o Presidente de Apafa</p>
            </div>

            <div class="container__historial">
                <img class="qr" src="{{ asset("qr/historial/$id_padre.png") }}" alt="">
                <p>Verifica tu historial</p>
            </div>

            <div class="container__qr">
                <img class="qr" src="{{ asset("qr/$id_padre.png") }}" alt="">
                <p>Registra tu Asistencia</p>
            </div>
        </div>
    </div>
</body>

</html>
