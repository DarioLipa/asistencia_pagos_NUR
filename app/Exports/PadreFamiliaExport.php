<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PadreFamiliaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
    public function view(): View
    {
        $datosPadreFamilia = DB::select("SELECT
        padre_familia.*,
        cargo.nombre as cargo ,
        tipo_consanguinidad.nombre as tipo_consanguinidad
        FROM
        padre_familia
        LEFT JOIN cargo ON padre_familia.id_cargo = cargo.id_cargo
        LEFT JOIN tipo_consanguinidad ON padre_familia.tipo_consanguinidad = tipo_consanguinidad.id_tipo_consanguinidad");
        return view('vistas/padres_familia.exportarPadreFamilia')->with('datosPadreFamilia', $datosPadreFamilia);
    }
}
