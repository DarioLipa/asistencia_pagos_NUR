<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            "txtidaporte" => "required",
            "txtidpadre" => "required",
            "txtidusuario" => "required",
            "txtmontoapotar" => "required",
            "txtmontoaportado" => "required",
            "txtmontodebe" => "required",
        ]);

        $id_aporte = $request->txtidaporte;
        $id_padre = $request->txtidpadre;
        $id_usuario = $request->txtidusuario;
        $monto_aportado = $request->txtmontoaportado;
        $monto_debe = $request->txtmontodebe;

        //verificar que el padre de familia con el id_aporte este registrado en la tabla aporte_padres
        $verificar = DB::select(
            "SELECT
            aporte_padres.id_aporte_padres,
            aporte_padres.id_aporte,
            aporte_padres.id_padre_familia,
            aporte_padres.monto_aporte,
            aporte_padres.monto_aportado,
            aporte_padres.monto_aporte - aporte_padres.monto_aportado as debe,
            aporte.monto
            FROM
            aporte_padres
            INNER JOIN aporte ON aporte_padres.id_aporte = aporte.id_aporte
            WHERE aporte_padres.id_aporte=? AND id_padre_familia=?
            ",
            [$id_aporte, $id_padre]
        );
        if ($verificar == null) {
            return back()->with("INCORRECTO", "El padre de familia no esta registrado en la tabla aporte_padres");
        }
        if ($verificar[0]->debe != null && $verificar[0]->debe == 0) {
            return back()->with("INCORRECTO", "El padre de familia ya cancelo el aporte");
        }

        //actualizar el monto aportado y el monto debe en la tabla aporte_padres
        $actualizar = DB::update(
            "UPDATE aporte_padres SET monto_aportado = COALESCE(monto_aportado, 0) + COALESCE(?, 0), debe=? WHERE id_aporte=? AND id_padre_familia=?",
            [$monto_aportado, $monto_debe, $id_aporte, $id_padre]
        );

        //registrar pago en la tabla pago
        $tituloAporte = DB::select("SELECT titulo FROM aporte WHERE id_aporte=?", [$id_aporte]);
        $titulo = $tituloAporte[0]->titulo;
        $registrar = DB::insert(
            "INSERT INTO pago(id_padre_familia, id_usuario, pago_concepto, monto_pago, debe) VALUES(?,?,?,?,?)",
            [$id_padre, $id_usuario, "APORTE: $titulo", $monto_aportado, $monto_debe]
        );

        if ($actualizar == 1 && $registrar == 1) {
            $id_pago = DB::getPdo()->lastInsertId();
            return back()->with([
                "id_pago" => $id_pago
            ]);
        } else {
            return back()->with("INCORRECTO", "El pago no se registro correctamente");
        }
    }

    public function pagarMultaReunion(Request $request)
    {
        //return $request;
        $request->validate([
            "txtidreunion" => "required",
            "txtidpadre" => "required",
            "txtidusuario" => "required",
            "txtmulta" => "required",
            "txtpago" => "required",
        ]);

        //verificar que la columna detalles de la tabla reunion_padres este vacia
        $verificar = DB::select(
            "SELECT
            reunion_padres.detalles,
            reunion_padres.id_reunion,
            reunion_padres.id_padre_familia,
            reunion_padres.asistencia
            FROM
            reunion_padres
            WHERE reunion_padres.id_reunion=? AND reunion_padres.id_padre_familia=?",
            [$request->txtidreunion, $request->txtidpadre]
        );
        if ($verificar[0]->asistencia == null and $verificar[0]->detalles != null) {
            return back()->with("INCORRECTO", "El padre de familia ya cancelo la multa");
        }

        //actualizar la columna detalles de la tabla reunion_padres
        $actualizar = DB::update(
            "UPDATE reunion_padres SET detalles=? WHERE id_reunion=? AND id_padre_familia=?",
            ["MULTA PAGADA", $request->txtidreunion, $request->txtidpadre]
        );

        //registrar pago en la tabla pago
        $tituloReunion = DB::select("SELECT titulo FROM reunion WHERE id_reunion=?", [$request->txtidreunion]);
        $titulo = $tituloReunion[0]->titulo;
        $registrar = DB::insert(
            "INSERT INTO pago(id_padre_familia, id_usuario, pago_concepto, monto_pago, debe) VALUES(?,?,?,?,?)",
            [$request->txtidpadre, $request->txtidusuario, "MULTA REUNION: $titulo", $request->txtpago, 0]
        );

        if ($actualizar == 1 && $registrar == 1) {
            //ultimo id
            $id_pago = DB::getPdo()->lastInsertId();
            return back()->with([
                "id_pago" => $id_pago
            ]);
        } else {
            return back()->with("INCORRECTO", "Error al registrar el pago");
        }
    }


    public function show($dni_padre)
    {
        $nombrePadreFamilia = DB::select("select concat(padre_nombres,' ',padre_ape_pat,' ', padre_ape_mat) as nombre, id_padre_familia from padre_familia where padre_dni=?", [$dni_padre]);
        if ($nombrePadreFamilia == null) {
            return back()->with("INCORRECTO", "El padre de familia no existe");
        }
        $id_padre = $nombrePadreFamilia[0]->id_padre_familia;
        $cantidadHijos = DB::select("SELECT COUNT(*) as cantidad FROM estudiante WHERE id_padre_familia=?", [$id_padre]);
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
                        ap.id_aporte_padres, ap.id_aporte, ap.id_padre_familia, aporte.titulo, aporte.descripcion, aporte.monto, aporte.fecha order by debe desc
            
        ",
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
            where id_padre_familia=? order by reunion.fecha desc ",
            [$id_padre]
        );

        return view("vistas/pagos.index", compact("historialAportes", "historialReuniones", "nombrePadreFamilia"))->with("cantidadHijos", $cantidadHijos[0]->cantidad);
    }

    public function ticketPago($id_pago)
    {
        $pagoDetalle = DB::select(" SELECT
        usuario.nombres,
        padre_familia.padre_nombres,
        padre_familia.padre_dni,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat,
        pago.id_pago,
        pago.monto_pago,
        pago.id_padre_familia,
        pago.pago_concepto
        FROM
        pago
        INNER JOIN padre_familia ON pago.id_padre_familia = padre_familia.id_padre_familia
        INNER JOIN usuario ON pago.id_usuario = usuario.id_usuario
        where id_pago=$id_pago ");

        $empresa = DB::select("SELECT * FROM empresa");
        $id_padre = $pagoDetalle[0]->id_padre_familia;

        $pdf = \App::make('dompdf.wrapper');
        //tamaño ticket
        $pdf->setPaper(array(0, 0, 200, 500));
        $pdf->loadView('vistas/pagos.ticket', compact('pagoDetalle', 'empresa', "id_padre"));
        return $pdf->stream("ticket_pago-$id_pago.pdf");
    }
}
