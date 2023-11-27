<?php

namespace App\Http\Controllers;

use App\Exports\aporteReporteExport;
use App\Models\Aporte;
use App\Models\Reunion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AporteController extends Controller
{
    public function index()
    {
        $aportes = Aporte::select(DB::raw('aporte.*, DATE(aporte.fecha) as fechaAp'), DB::raw('(SELECT COUNT(*) FROM aporte_padres WHERE aporte_padres.id_aporte = aporte.id_aporte) as total'))
            ->orderBy('aporte.id_aporte', 'desc')
            ->paginate(10);



        //$reunion_padres = DB::select("select * from reunion_padres");
        $totalParticipantes = DB::select(" SELECT
            Count(*),
            aporte_padres.id_aporte,
            aporte.titulo
            FROM
            aporte_padres
            INNER JOIN aporte ON aporte_padres.id_aporte = aporte.id_aporte
            GROUP BY id_aporte ");

        return view("vistas/aportes.index", compact("aportes"))->with("totalParticipantes", $totalParticipantes);
    }



    public function store(Request $request)
    {
        $request->validate([
            "txttitulo" => "required",
            "txtdescripcion" => "required",
            "txtmonto" => "required",
            "txtfecha" => "required",
        ]);
        //registrar
        $aporte = new Aporte();
        $aporte->titulo = $request->txttitulo;
        $aporte->descripcion = $request->txtdescripcion;
        $aporte->monto = $request->txtmonto;
        $aporte->fecha = $request->txtfecha;
        $aporte->save();

        //redireccionar a la vista de agregar participantes 
        return redirect()->route("aportes.vistaAgregarParticipante", $aporte->id_aporte)->with("CORRECTO", "Aporte registrada exitosamente");
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            "txttitulo" => "required",
            "txtdescripcion" => "required",
            "txtmonto" => "required",
            "txtfecha" => "required",
        ]);
        //modificar
        $reunion = Aporte::findOrFail($id);
        $reunion->titulo = $request->txttitulo;
        $reunion->descripcion = $request->txtdescripcion;
        $reunion->monto = $request->txtmonto;
        $reunion->fecha = $request->txtfecha;
        $reunion->save();

        //actualizar el campo monto de la tabla aporte_padres, segun cuantos estudiantes tenga el padre de familia
        $montoAporte = DB::select("SELECT monto FROM aporte WHERE id_aporte=?", [$id]);
        $participantes = DB::select("SELECT * FROM aporte_padres WHERE id_aporte = ?", [$id]);
        foreach ($participantes as $participante) {
            $cantidadHijos = DB::select("SELECT COUNT(*) as cantidad FROM estudiante where id_padre_familia=?", [$participante->id_padre_familia]);
            $montoDebe = $montoAporte[0]->monto * $cantidadHijos[0]->cantidad;
            DB::update("UPDATE aporte_padres SET monto_aporte = ? WHERE id_aporte = ? AND id_padre_familia = ?", [$montoDebe, $id, $participante->id_padre_familia]);
        }


        return redirect()->route("aportes.index")->with("CORRECTO", "Aporte modificada exitosamente");
    }


    public function destroy($id)
    {
        //eliminar
        // verificar si el aporte tiene participantes
        // $participantes = DB::select("SELECT * FROM aporte_padres WHERE id_aporte = ?", [$id]);
        // if (count($participantes) > 0) {
        //     return back()->with("INCORRECTO", "No se puede eliminar el aporte porque tiene participantes vinculados");
        // }


        $aporte = Aporte::findOrFail($id);
        $aporte->delete();
        return redirect()->route("aportes.index")->with("CORRECTO", "Aporte eliminada exitosamente");
    }

    public function addParticipante(Request $request)
    {
        $request->validate([
            "txtidaporte" => "required",
            "txtidparticipante" => "required",
        ]);

        $idParticipantes = explode(",", $request->txtidparticipante);
        $montoAporte = DB::select("SELECT monto FROM aporte WHERE id_aporte=?", [$request->txtidaporte]);
        //insertar cada participante en la tabla reunion_padres
        foreach ($idParticipantes as $idParticipante) {
            //verificar si ya existe el participante en la reunion
            $existe = DB::select("SELECT * FROM aporte_padres WHERE id_aporte = ? AND id_padre_familia = ?", [$request->txtidaporte, $idParticipante]);
            $cantidadHijos = DB::select("SELECT COUNT(*) as cantidad FROM estudiante where id_padre_familia=?", [$idParticipante]);
            $montoDebe = $montoAporte[0]->monto * $cantidadHijos[0]->cantidad;
            if (count($existe) <= 0) {
                DB::insert("INSERT INTO aporte_padres (id_aporte, id_padre_familia, monto_aporte, monto_aportado) VALUES (?, ?, ?, 0)", [$request->txtidaporte, $idParticipante, $montoDebe]);
            }
        }

        return back()->with("CORRECTO", "Participantes agregados exitosamente");
    }


    public function vistaAgregarParticipante($id_aporte)
    {

        $aporte = DB::select("SELECT * FROM aporte WHERE id_aporte = ?", [$id_aporte]);

        //aqui se obtiene un si. si los participantes ya estan vinculados en el aporte caso contrario no
        $padresFamilia = DB::select(" SELECT
            padre_familia.*,
            cargo.nombre AS cargo,
            tipo_consanguinidad.nombre AS nombre_consanguinidad,
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM aporte_padres
                    WHERE aporte_padres.id_padre_familia = padre_familia.id_padre_familia
                    AND aporte_padres.id_aporte = $id_aporte
                ) THEN 'si'
                ELSE 'no'
            END AS esta_vinculado_en_reunion
        FROM
            padre_familia
        LEFT JOIN
            cargo ON padre_familia.id_cargo = cargo.id_cargo
        LEFT JOIN
            tipo_consanguinidad ON padre_familia.tipo_consanguinidad = tipo_consanguinidad.id_tipo_consanguinidad
        WHERE EXISTS (
            SELECT 1
            FROM estudiante
            WHERE estudiante.id_padre_familia = padre_familia.id_padre_familia
        )
     ");

        return view("vistas/aportes.agregarParticipante", compact("padresFamilia"))->with("id_aporte", $id_aporte)->with("aporte", $aporte);
    }


    public function eliminarParticipante($id_aporte)
    {
        //eliminar
        $eliminar = DB::delete("delete from aporte_padres where id_aporte = ?", [$id_aporte]);
        return back()->with("CORRECTO", "Participantes eliminados exitosamente");
    }

    public function aportesReporte($id_aporte)
    {
        $datosNoAdeudados = DB::select("SELECT
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
        where aporte_padres.id_aporte = ? and (monto_aportado = monto_aporte ) and monto_aporte!=0  order by padre_ape_pat asc", [$id_aporte]);

        $datosAdeudados = DB::select("SELECT
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
        where aporte_padres.id_aporte = ? and ((monto_aporte - monto_aportado) > 0 ) and monto_aporte!=0 order by padre_ape_pat asc", [$id_aporte]);

        $tituloAporte = DB::select("SELECT titulo FROM aporte WHERE id_aporte=?", [$id_aporte]);

        $sumaTotalNoAdeudados = DB::select("SELECT SUM(monto_aporte) as sumaTotalNoAdeudados FROM aporte_padres WHERE id_aporte=? and (monto_aportado = monto_aporte ) and monto_aporte!=0", [$id_aporte]);
        $sumaTotalAdeudados = DB::select("SELECT SUM(monto_aporte) as sumaTotalAdeudados FROM aporte_padres WHERE id_aporte=? and ((monto_aporte - monto_aportado) > 0 ) and monto_aporte!=0", [$id_aporte]);
        $sumaTotal = $sumaTotalNoAdeudados[0]->sumaTotalNoAdeudados + $sumaTotalAdeudados[0]->sumaTotalAdeudados;

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes/reporte_aportes', compact('datosNoAdeudados', "datosAdeudados", "tituloAporte", "sumaTotalNoAdeudados", "sumaTotalAdeudados", "sumaTotal"));
        return $pdf->stream("reporte de aportes.pdf");
    }

    public function aportesReporteExcel($id_aporte)
    {
        return Excel::download(new aporteReporteExport($id_aporte), "aporteReporte.xlsx");
    }

    
}
