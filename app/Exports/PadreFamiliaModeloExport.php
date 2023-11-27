<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PadreFamiliaModeloExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $cargo = DB::select('select * from cargo');
        $consanguinidad = DB::select('select * from tipo_consanguinidad');
        return view('vistas/padres_familia.exportarModeloPadreFamilia', [
            'cargo' => $cargo,
            'consanguinidad' => $consanguinidad
        ]);
    }
}
