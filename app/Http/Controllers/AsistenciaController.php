<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    public function entrada($id_reunion, $dniPadreFamilia)
    {
        //verificar el estado de la reunion
        $reunion = DB::select("SELECT * FROM reunion where id_reunion=$id_reunion and id_estado_reunion=1");
        if (count($reunion) == 0) {
            return back()->with("INCORRECTO", "La reunión no esta activa");
        }

        if ($id_reunion == null || $dniPadreFamilia == null) {
            return back()->with("INCORRECTO", "Ingrese todos los campos");
        }
        $buscarID = DB::select("select id_padre_familia from padre_familia where padre_dni=$dniPadreFamilia");

        if ($buscarID == null) {
            return back()->with("INCORRECTO", "No se encontro el padre de familia");
        }

        $idPadreFamilia = $buscarID[0]->id_padre_familia;

        $buscarReunion = DB::select(" select * from reunion_padres where id_reunion=$id_reunion and id_padre_familia=$idPadreFamilia ");

        if ($buscarReunion == null) {
            return back()->with("INCORRECTO", "No estas inscrito en la reunión");
        } else {
            if ($buscarReunion[0]->Asistencia != null) {
                return back()->with("INCORRECTO", "Ya tienes marcada tu entrada");
            } else {
                $fechaActual = date("Y-m-d H:i:s");
                $res = DB::update("update reunion_padres set asistencia='$fechaActual' where id_reunion=$id_reunion and id_padre_familia=$idPadreFamilia");
                if ($res) {
                    return back()->with("CORRECTO", "Entrada marcada correctamente");
                } else {
                    return back()->with("INCORRECTO", "No se pudo marcar la entrada");
                }
            }
        }
    }

    public function salida($id_reunion, $dniPadreFamilia)
    {
        if ($id_reunion == null || $dniPadreFamilia == null) {
            return back()->with("INCORRECTO", "Ingrese todos los campos");
        }
        $buscarID = DB::select("select id_padre_familia from padre_familia where padre_dni=$dniPadreFamilia");

        if ($buscarID == null) {
            return back()->with("INCORRECTO", "No se encontro el padre de familia");
        }

        $idPadreFamilia = $buscarID[0]->id_padre_familia;

        $buscarReunion = DB::select(" select * from reunion_padres where id_reunion=$id_reunion and id_padre_familia=$idPadreFamilia ");

        if ($buscarReunion[0]->Asistencia == null) {
            return back()->with("INCORRECTO", "Primero debes marcar tu entrada");
        }

        if ($buscarReunion == null) {
            return back()->with("INCORRECTO", "No se encontro la reunion");
        } else {
            if ($buscarReunion[0]->Asistencia_salida != null) {
                return back()->with("INCORRECTO", "Ya tienes marcada tu salida");
            } else {
                $fechaActual = date("Y-m-d H:i:s");
                $res = DB::update("update reunion_padres set asistencia_salida='$fechaActual' where id_reunion=$id_reunion and id_padre_familia=$idPadreFamilia");
                if ($res) {
                    return back()->with("CORRECTO", "Salida marcada correctamente");
                } else {
                    return back()->with("INCORRECTO", "No se pudo marcar la salida");
                }
            }
        }
    }
}
