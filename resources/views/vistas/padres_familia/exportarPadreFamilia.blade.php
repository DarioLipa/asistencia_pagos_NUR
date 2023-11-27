<table>
    <thead>
        <tr>
            <th>DNI</th>
            <th>Cargo</th>
            <th>Tipo consanguinidad</th>
            <th>Nombres del padre de familia</th>
            <th>Apellido paterno</th>
            <th>Apellido Materno</th>
            <th>Celular</th>
            <th>Direccion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datosPadreFamilia as $padreFamilia)
            <tr>
                <td>{{ $padreFamilia->padre_dni }}</td>
                <td>{{ $padreFamilia->cargo }}</td>
                <td>{{ $padreFamilia->tipo_consanguinidad }}</td>
                <td>{{ $padreFamilia->padre_nombres }}</td>
                <td>{{ $padreFamilia->padre_ape_pat }}</td>
                <td>{{ $padreFamilia->padre_ape_mat }}</td>
                <td>{{ $padreFamilia->celular }}</td>
                <td>{{ $padreFamilia->direccion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
