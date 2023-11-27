<table>
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombres del estudiante</th>
            <th>Apellido paterno</th>
            <th>Apellido Materno</th>
            <th>Datos del padre de familia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datosEstudiante as $estudiante)
            <tr>
                <td>{{ $estudiante->dni }}</td>
                <td>{{ $estudiante->nombres }}</td>
                <td>{{ $estudiante->ape_pat }}</td>
                <td>{{ $estudiante->ape_mat }}</td>
                <td>{{ $estudiante->padre_ape_pat . ' ' . $estudiante->padre_ape_mat . ' ' . $estudiante->padre_nombres . ' - ' . $estudiante->padre_dni }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
