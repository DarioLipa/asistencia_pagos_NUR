<table>
    <thead>
        {{-- <tr>
            <th style="background: yellow" colspan="8">DATOS DE LOS PADRES DE FAMILIA</th>
        </tr> --}}
        <tr>
            <th style="background: yellow">ID CARGO(ingresa el codigo)</th>
            <th style="background: yellow">CONSANGUINIDAD(ingresa el codigo)</th>
            <th style="background: yellow">DNI</th>
            <th style="background: yellow">NOMBRES</th>
            <th style="background: yellow">APELLIDO PATERNO</th>
            <th style="background: yellow">APELLIDO MATERNO</th>
            <th style="background: yellow">CELULAR</th>
            <th style="background: yellow">DIRECCION</th>

            <table>
                <tbody>
                    <thead>
                        {{-- <tr>
                            <th style="background: skyblue" colspan="2">CARGOS</th>
                        </tr> --}}
                        <tr>
                            <th style="background: skyblue">CODIGO CARGO</th>
                            <th style="background: skyblue">VALOR</th>
                        </tr>
                    </thead>
                    @foreach ($cargo as $item)
                        <tr>
                            <td style="background: skyblue">{{ $item->id_cargo }}</td>
                            <td style="background: skyblue">{{ $item->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table>
                <tbody>
                    <thead>
                        {{-- <tr>
                            <th style="background: greenyellow" colspan="2">CONSANGUINIDAD</th>
                        </tr> --}}
                        <tr>
                            <th style="background: greenyellow">CODIGO CONSANGUINIDAD</th>
                            <th style="background: greenyellow">VALOR</th>
                        </tr>
                    </thead>
                    @foreach ($consanguinidad as $item)
                        <tr>
                            <td style="background: greenyellow">{{ $item->id_tipo_consanguinidad }}</td>
                            <td style="background: greenyellow">{{ $item->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
