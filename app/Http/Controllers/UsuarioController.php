<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view("vistas/usuarios.index", compact("usuarios"));
    }


    public function store(Request $request)
    {
        $request->validate([
            "txtnombre" => "required",
            "txtusuario" => "required",
            "txtclave" => "required",
            "txtcorreo" => "required",
        ]);
        $validarUsuario = DB::select("SELECT * FROM usuario WHERE usuario='$request->txtusuario'");
        if (count($validarUsuario) > 0) {
            return redirect()->route("usuarios.index")->with("INCORRECTO", "El usuario ya existe");
        }
        $cargo = new Usuario();
        $cargo->nombres = $request->txtnombre;
        $cargo->usuario = $request->txtusuario;
        $cargo->password = md5($request->txtclave);
        $cargo->correo = $request->txtcorreo;
        $cargo->estado=1;
        $cargo->save();
        return redirect()->route("usuarios.index")->with("CORRECTO", "Usuario registrado exitosamente");
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            "txtnombre" => "required",
            "txtusuario" => "required",
            "txtcorreo" => "required", "txtnombre" => "required",
        ]);
        //validar que el cargo no exista con el mismo nombre
        $validarUsuario = DB::select("SELECT * FROM usuario WHERE usuario='$request->txtusuario' and id_usuario!='$id'");
        if (count($validarUsuario) > 0) {
            return redirect()->route("usuarios.index")->with("INCORRECTO", "El usuario ya existe");
        } else {
            $cargo = Usuario::findOrFail($id);
            $cargo->nombres = $request->txtnombre;
            $cargo->usuario = $request->txtusuario;
            $cargo->correo = $request->txtcorreo;
            $cargo->save();
            return redirect()->route("usuarios.index")->with("CORRECTO", "Usuario actualizado exitosamente");
        }
    }


    public function destroy($id)
    {
        $cargo = Usuario::findOrFail($id);
        $cargo->delete();
        return redirect()->route("usuarios.index")->with("CORRECTO", "Usuario eliminado exitosamente");
    }







    public function perfilIndex()
    {
        $id = Auth::user()->id_usuario;
        $sql = DB::select(" select * from usuario where id_usuario=$id ");
        return view("vistas/perfil", compact("sql"));
    }
    public function perfilUpdate(Request $request)
    {
        $request->validate([
            "id" => "required",
            "txtnombre" => "required",
            "txtusuario" => "required",
            "txtcorreo" => "required",
        ]);

        try {
            $sql = DB::update(" update usuario set nombres=?, usuario=?, correo=? where id_usuario=? ", [
                $request->txtnombre,
                $request->txtusuario,
                $request->txtcorreo,
                $request->id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Datos modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }
//clave
    public function claveIndex()
    {
        $id = Auth::user()->id_usuario;
        return view("vistas/cambiarClave", compact("id"));
    }

    public function claveUpdate(Request $request)
    {

        $request->validate([
            "claveActual" => "required",
            "claveNuevo" => "required",
        ]);

        $id = Auth::user()->id_usuario;
        $verClaveAn = DB::select(" select password from usuario where id_usuario=$id ");
        $pass = md5($request->claveNuevo);

        if ($verClaveAn[0]->password != md5($request->claveActual)) {
            return back()->with("AVISO", "La contraseña actual es INCORRECTA");
        }
        try {
            $sql = DB::update(" update usuario set password=? where id_usuario=? ", [
                $pass,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Contraseña modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }
}
