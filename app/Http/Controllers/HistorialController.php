<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    public function index()
    {
        return view("vistas/historial.index");
    }

    public function show(Request $request)
    {
        $request->validate([
            "txtdni" => "required",
        ]);

        $id_padre = DB::select(" select id_padre_familia from padre_familia where padre_dni = ?", [$request->txtdni]);
        if (count($id_padre) <= 0) {
            return response()->json([
                "message" => "No se encontro el padre de familia",
            ], 400);
        }

        $nombrePadreFamilia = DB::select("select concat(padre_nombres,' ',padre_ape_pat,' ', padre_ape_mat) as nombre from padre_familia where id_padre_familia=?", [$id_padre[0]->id_padre_familia]);

        $cantidadHijos = DB::select("SELECT COUNT(*) as cantidad FROM estudiante WHERE id_padre_familia=?", [$id_padre[0]->id_padre_familia]);
        $historialAportes = DB::select(
            "SELECT
            ap.id_aporte_padres,
            ap.id_aporte,
            ap.id_padre_familia,
            ap.monto_aportado,
            aporte.titulo,
            aporte.descripcion,
            aporte.monto,
            aporte.fecha,
            ap.monto_aporte,
            (ap.monto_aporte - monto_aportado) as debe
            FROM
            aporte_padres AS ap
            INNER JOIN aporte ON ap.id_aporte = aporte.id_aporte
            WHERE
                        ap.id_padre_familia = ?
            GROUP BY
                        ap.id_aporte_padres, ap.id_aporte, ap.id_padre_familia, aporte.titulo, aporte.descripcion, aporte.monto, aporte.fecha order by debe desc",
            [$id_padre[0]->id_padre_familia]
        );

        $historialReuniones = DB::select(
            " SELECT
            reunion_padres.*,
            reunion.titulo,
            reunion.id_estado_reunion,
            reunion.descripcion,
            reunion.multa_precio,
            reunion.fecha,
            reunion.hora,
            estado_reunion.estado
            FROM
            reunion_padres
            INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
            INNER JOIN estado_reunion ON reunion.id_estado_reunion = estado_reunion.id_estado_reunion        
            where id_padre_familia=?",
            [$id_padre[0]->id_padre_familia]
        );


        return response()->json([
            "historialAportes" => $historialAportes,
            "historialReuniones" => $historialReuniones,
            "nombrePadreFamilia" => $nombrePadreFamilia[0]->nombre,
            "dni" => $request->txtdni,
            "cantidadHijos" => $cantidadHijos[0]->cantidad,
        ], 200);
    }

    public function descargaPDF($dni_padre)
    {
        //validar que exista el padre de familia
        $padreExiste = DB::select("select id_padre_familia from padre_familia where padre_dni=?", [$dni_padre]);
        if ($padreExiste == null) {
            return back()->with("INCORRECTO", "El padre de familia no existe");
        }


        $nombrePadreFamilia = DB::select("select concat(padre_nombres,' ',padre_ape_pat,' ', padre_ape_mat) as nombre, id_padre_familia from padre_familia where padre_dni=?", [$dni_padre]);
        $id_padre = $nombrePadreFamilia[0]->id_padre_familia;
        $cantidadHijos = DB::select("SELECT COUNT(*) as cantidad FROM estudiante WHERE id_padre_familia=?", [$id_padre]);
        $cantidadHijos = $cantidadHijos[0]->cantidad;
        $historialAportes = DB::select(
            "SELECT
            ap.id_aporte_padres,
            ap.id_aporte,
            ap.id_padre_familia,
            ap.monto_aportado,
            aporte.titulo,
            aporte.descripcion,
            aporte.monto,
            aporte.fecha,
            ap.monto_aporte,
            (ap.monto_aporte - monto_aportado) as debe
            FROM
            aporte_padres AS ap
            INNER JOIN aporte ON ap.id_aporte = aporte.id_aporte
            WHERE
                        ap.id_padre_familia = ?
            GROUP BY
                        ap.id_aporte_padres, ap.id_aporte, ap.id_padre_familia, aporte.titulo, aporte.descripcion, aporte.monto, aporte.fecha order by debe desc",
            [$id_padre]
        );

        $historialReuniones = DB::select(
            " SELECT
            reunion_padres.*,
            reunion.titulo,
            reunion.id_estado_reunion,
            reunion.descripcion,
            reunion.multa_precio,
            reunion.fecha,
            reunion.hora,
            estado_reunion.estado
            FROM
            reunion_padres
            INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
            INNER JOIN estado_reunion ON reunion.id_estado_reunion = estado_reunion.id_estado_reunion        
            where id_padre_familia=?",
            [$id_padre]
        );

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper([0, 0, 105, 148], 'portrait');
        //poner tamaño a4 vertical
        $pdf->setPaper('A4', 'landscape');
        $pdf->loadView('vistas/historial.historialPDF', compact("dni_padre", "nombrePadreFamilia", "historialAportes", "historialReuniones", "cantidadHijos"));
        return $pdf->stream("historial-$dni_padre.pdf");
    }
}
