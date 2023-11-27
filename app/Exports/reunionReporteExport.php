<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class reunionReporteExport implements FromView
{
    private $id_reunion;

    public function __construct($id_reunion)
    {
        $this->id_reunion = $id_reunion;
    }
    public function view():view
    {
        $id_reunion = $this->id_reunion;
        $datos = DB::select("SELECT
        padre_familia.padre_dni,
        padre_familia.padre_nombres,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat,
        padre_familia.celular,
        reunion_padres.asistencia,
        reunion_padres.detalles,
        reunion.titulo,
        reunion.descripcion,
        reunion.multa_precio,
        reunion.fecha,
        reunion.hora
        FROM
        padre_familia
        INNER JOIN reunion_padres ON reunion_padres.id_padre_familia = padre_familia.id_padre_familia
        INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
        where reunion.id_reunion = ?", [$id_reunion]);

        $tituloAporte = DB::select("SELECT titulo FROM reunion WHERE id_reunion=?", [$id_reunion]);

        return view("vistas/reportes/reporte_reunionesExcel", compact("datos", "tituloAporte"));
    }
}
