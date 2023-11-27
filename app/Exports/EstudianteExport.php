<?php

namespace App\Exports;

use App\Models\Estudiante;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class EstudianteExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Estudiante::all();
    }

    public function view(): View
    {
        $datosEstudiante = DB::select("SELECT
        estudiante.*,
        padre_familia.padre_dni,
        padre_familia.padre_nombres,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat
        FROM
        estudiante
        INNER JOIN padre_familia ON estudiante.id_padre_familia = padre_familia.id_padre_familia");
        return view('vistas/estudiantes.exportarEstudiante')->with('datosEstudiante', $datosEstudiante);
    }
}
