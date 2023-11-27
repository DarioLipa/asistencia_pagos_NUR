<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class aporteReporteExport implements FromView
{
    private $id_aporte;

    public function __construct($id_aporte)
    {
        $this->id_aporte = $id_aporte;
    }
    public function view(): view
    {
        $id_aporte = $this->id_aporte;
        $datos = DB::select("SELECT
        aporte_padres.id_aporte_padres,
        aporte_padres.id_aporte,
        aporte_padres.id_padre_familia,
        aporte_padres.monto_aporte,
        aporte_padres.monto_aportado,
        aporte_padres.debe,
        aporte.fecha,
        aporte.monto,
        aporte.descripcion,
        aporte.titulo,
        padre_familia.padre_dni,
        padre_familia.padre_nombres,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat
        FROM
        aporte_padres
        INNER JOIN aporte ON aporte_padres.id_aporte = aporte.id_aporte
        INNER JOIN padre_familia ON aporte_padres.id_padre_familia = padre_familia.id_padre_familia
        where aporte_padres.id_aporte = ?", [$id_aporte]);

        $tituloAporte = DB::select("SELECT titulo FROM aporte WHERE id_aporte=?", [$id_aporte]);

        return view("vistas/reportes/reporte_aportesExcel", compact("datos", "tituloAporte"));
    }
}
