<?php

namespace App\Http\Controllers;

use App\Models\Reunion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscanerController extends Controller
{
    public function show($id)
    {
        $tituloReunion = DB::select("SELECT * FROM reunion WHERE id_reunion = ?", [$id]);
        return view("vistas/escanear.index", compact("tituloReunion", "id"));
    }

    public function escanear($id_reunion, $id_padre_familia)
    {
        return back()->with("CORRECTO", "Asistencia registrada correctamente");
    }
}
