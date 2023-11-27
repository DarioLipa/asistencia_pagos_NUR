<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de pago</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: auto;
        background: rgb(255, 255, 255);
        font-size: 5px;
        background: rgb(255, 255, 255);
        font-family: 'Roboto', sans-serif;
        padding: 8px;
        position: relative;
        border: 1px solid #000;
    }

    .image img {
        width: 15px;
        position: absolute;
        top: 10;
    }

    .foto__institucion {
        left: 15;
    }

    .foto__ugel {
        right: 15;
    }

    h1 {
        text-align: center;
        padding: 5px 50px;
        background: rgb(5, 46, 84);
        color: rgb(255, 255, 255);
        font-weight: bold;
        margin-bottom: 0;
        margin-top: 0;
        font-size: 12px;
    }

    /* estilos de la tabla */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        font-size: 8px;
        background: rgb(236, 246, 255);
    }

    th,
    td {
        border: 0.2px solid #000;
        padding: 3px;
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
        <h1>TICKET DE PAGO</h1>
        @foreach ($empresa as $item)
            <div class="image">
                <img class="foto__institucion"
                    src="{{ public_path("storage/ARCHIVOS/empresa/$item->foto_institucion") }}" alt="foto institucion">

                <img class="foto__ugel" src="{{ public_path("storage/ARCHIVOS/empresa/$item->foto_ugel") }}"
                    alt="foto UGEL">
            </div>
        @endforeach
        <div class="content">
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
                @foreach ($pagoDetalle as $itemPago)
                    <tbody>
                        <tr>
                            <td colspan="2" class="title">Detalles del pago</td>
                        </tr>
                        <tr>
                            <td class="title">Id pago</td>
                            <td>{{ $itemPago->id_pago }}</td>
                        </tr>
                        <tr>
                            <td class="title">Padre de familia</td>
                            <td>{{ $itemPago->padre_ape_pat . ' ' . $itemPago->padre_ape_mat . ' ' . $itemPago->padre_nombres }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Pago concepto</td>
                            <td>{{ $itemPago->pago_concepto }}</td>
                        </tr>
                        <tr>
                            <td class="title">Monto</td>
                            <td>S/. {{ $itemPago->monto_pago }}</td>
                        </tr>
                        <tr>
                            <td class="title">Pago registrado por...</td>
                            <td>{{ $itemPago->nombres }}</td>
                        </tr>

                    </tbody>
                @endforeach
            </table>


            <br>
            <br>
            <br>
            <br><br><br><br>
            <div class="sello">
                <p>--------------------------------------------------------------------</p>
                <p class="post">Director, Presidente de Apafa o Tesorero(a)</p>
            </div>

            {{-- <div class="container__historial">
                <img class="qr" src="{{ asset("qr/historial/$id_padre.png") }}" alt="">
                <p>Verifica tu historial</p>
            </div> --}}
        </div>
    </div>
</body>

</html>
