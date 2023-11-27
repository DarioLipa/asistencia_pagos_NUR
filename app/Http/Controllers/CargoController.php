<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{

    public function index()
    {
        $cargos = Cargo::all();
        return view("vistas/cargos.index", compact("cargos"));
    }


    public function store(Request $request)
    {
        $request->validate([
            "txtnombre" => "required",
        ]);
        $validarNombre = DB::select("SELECT * FROM cargo WHERE nombre='$request->txtnombre'");
        if (count($validarNombre) > 0) {
            return redirect()->route("cargos.index")->with("INCORRECTO", "El cargo ya existe");
        }
        $cargo = new Cargo();
        $cargo->nombre = $request->txtnombre;
        $cargo->save();
        return redirect()->route("cargos.index")->with("CORRECTO", "Cargo registrado exitosamente");
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            "txtnombre" => "required",
        ]);
        //validar que el cargo no exista con el mismo nombre
        $validarNombre = DB::select("SELECT * FROM cargo WHERE nombre='$request->txtnombre' and id_cargo!='$id'");
        if (count($validarNombre) > 0) {
            return redirect()->route("cargos.index")->with("INCORRECTO", "El cargo ya existe");
        } else {
            $cargo = Cargo::findOrFail($id);
            $cargo->nombre = $request->txtnombre;
            $cargo->save();
            return redirect()->route("cargos.index")->with("CORRECTO", "Cargo actualizado exitosamente");
        }
    }


    public function destroy($id)
    {
        //validar que el cargo no esté vinculado en la tabla padre_familia
        $validarCargo = DB::select("SELECT * FROM padre_familia WHERE id_cargo='$id'");
        if (count($validarCargo) > 0) {
            return redirect()->route("cargos.index")->with("INCORRECTO", "El cargo no se puede eliminar porque está vinculado a un padre de familia");
        }
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();
        return redirect()->route("cargos.index")->with("CORRECTO", "Cargo eliminado exitosamente");
    }

    public function vacearRegistro()
    {
        //validar que el cargo no esté vinculado en la tabla padre_familia
        $validarCargo = DB::select("SELECT * FROM padre_familia");
        if (count($validarCargo) > 0) {
            return redirect()->route("cargos.index")->with("INCORRECTO", "El cargo no se puede eliminar porque está vinculado a un padre de familia");
        }
        $eliminarTodo = DB::delete("DELETE FROM cargo");
        return redirect()->route("cargos.index")->with("CORRECTO", "Registros eliminados exitosamente");
    }
}
