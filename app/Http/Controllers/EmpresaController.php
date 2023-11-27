<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index()
    {
        try {
            $sql = DB::select('select * from empresa');
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('vistas/empresa/empresa', compact("sql"));
    }
    public function update(Request $request, $id)
    {
        try {
            $sql = DB::update('update empresa set nombre=?, cod_modular=?, ubicacion=?, telefono=?, correo=? where id_empresa=?', [
                $request->nombre,
                $request->cod_modular,
                $request->ubicacion,
                $request->telefono,
                $request->correo,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with('CORRECTO', 'Datos modificados correctamente');
        } else {
            return back()->with('INCORRECTO', 'Error al modificar');
        }
    }

    public function subirImgInstitucion(Request $request)
    {
        $request->validate([
            "foto" => "required|image|mimes:jpg,jpeg,png"
        ]);

        //primeramente eliminamos la img anterior
        $logo_antiguo = DB::select("select foto_institucion from empresa");
        if ($logo_antiguo[0]->foto_institucion != null) {
            $ruta_file = storage_path("app/public/ARCHIVOS/empresa/" . $logo_antiguo[0]->foto_institucion);
            try {
                unlink($ruta_file);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $file = $request->file("foto");
        $nombre_file = "logo-" . strtolower($file->getClientOriginalName());
        $ruta_file = storage_path("app/public/ARCHIVOS/empresa/" . $nombre_file);
        $res = move_uploaded_file($file, $ruta_file);

        //actualizamos el campo foto_institucion
        $empresa = DB::update("update empresa set foto_institucion=?", [$nombre_file]);

        if ($res and $empresa) {
            return back()->with('CORRECTO', 'Imagen subida correctamente');
        } else {
            return back()->with('INCORRECTO', 'Error al subir imagen');
        }
    }

    public function eliminarImgInstitucion()
    {
        $logo_antiguo = DB::select("select foto_institucion from empresa");
        $nombre_logo_antiguo = $logo_antiguo[0]->foto_institucion;
        if ($nombre_logo_antiguo != null) {
            $ruta = storage_path("app/public/ARCHIVOS/empresa/$nombre_logo_antiguo");
            try {
                unlink($ruta);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        //actualizamos bd
        $empresa = DB::update(" update empresa set foto_institucion='' ");

        if ($empresa) {
            return redirect()->back()->with("CORRECTO", "Imagen eliminada correctamente");
        } else {
            return redirect()->back()->with("INCORRECTO", "Error al eliminar la imagen");
        }
    }

    public function subirImgUgel(Request $request)
    {
        $request->validate([
            "fotoUgel" => "required|image|mimes:jpg,png,jpeg"
        ]);

        //eliminamos la imagen anterior
        $consultaImg = DB::select("select foto_ugel from empresa");
        if ($consultaImg[0]->foto_ugel != null) {
            $rutaAntigua = storage_path("app/public/ARCHIVOS/empresa/" . $consultaImg[0]->foto_ugel);
            try {
                unlink($rutaAntigua);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $file = $request->file("fotoUgel");
        $nombre_file = strtolower("logoUgel-" . $file->getClientOriginalName());
        $url_file = storage_path("app/public/ARCHIVOS/empresa/" . $nombre_file);
        $res = move_uploaded_file($file, $url_file);

        //actualizamos la bd
        $empresa = DB::update("update empresa set foto_ugel=?", [$nombre_file]);

        if ($res and $empresa) {
            return back()->with("CORRECTO", "Imagen almacenada correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al almacenar imagen");
        }
    }

    public function eliminarImgUgel()
    {
        $imgAntiguo = DB::select("select foto_ugel from empresa");
        if ($imgAntiguo[0]->foto_ugel != null) {
            $urlAntiguo = storage_path("app/public/ARCHIVOS/empresa/" . $imgAntiguo[0]->foto_ugel);
            try {
                unlink($urlAntiguo);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        //actualizamos bd
        $empresa = DB::update("update empresa set foto_ugel=''");
        if ($empresa) {
            return back()->with("CORRECTO", "Imagen eliminada correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar imagen");
        }
    }
}
