<?php

namespace App\Http\Controllers;

use App\Exports\EstudianteExport;
use App\Imports\EstudianteImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EstudianteController extends Controller
{

    public function index()
    {

        $datosEstudiante = DB::table('estudiante')
            ->join('padre_familia', 'estudiante.id_padre_familia', '=', 'padre_familia.id_padre_familia')
            ->select(
                'estudiante.*',
                'padre_familia.padre_nombres',
                'padre_familia.padre_dni',
                'padre_familia.padre_ape_pat',
                'padre_familia.padre_ape_mat'
            )
            ->paginate(10);

        $padreFamilia = DB::select('select * from padre_familia order by padre_ape_pat asc');

        return view('vistas/estudiantes.index', compact("datosEstudiante"))->with('padreFamilia', $padreFamilia);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'txtnombre' => 'required',
                'txtapellidopaterno' => 'required',
                'txtapellidomaterno' => 'required',
                'txtdni' => 'required',
                'txtpadrefamilia' => 'required'
            ]
        );
        //validar que el dni no se repita
        $dni = $request->txtdni;
        $dniRepetido = DB::select('select * from estudiante where dni = ?', [$dni]);
        if ($dniRepetido) {
            return redirect()->route('estudiantes.index')->with('INCORRECTO', 'El DNI ingresado ya existe');
        } else {
            //insertar datos
            $nombre = $request->txtnombre;
            $apellidoPaterno = $request->txtapellidopaterno;
            $apellidoMaterno = $request->txtapellidomaterno;
            $dni = $request->txtdni;
            $padreFamilia = $request->txtpadrefamilia;

            $res = DB::insert('insert into estudiante (id_padre_familia, dni, nombres, ape_pat, ape_mat) values (?, ?, ?, ?, ?)', [$padreFamilia, $dni, $nombre, $apellidoPaterno, $apellidoMaterno]);
            if ($res) {
                return redirect()->route('estudiantes.index')->with('CORRECTO', 'Estudiante registrado correctamente');
            } else {
                return redirect()->route('estudiantes.index')->with('INCORRECTO', 'Error al registrar estudiante');
            }
        }
    }


    public function show($id)
    {
        $datosEstudiante = DB::select("SELECT
        estudiante.*,
        padre_familia.padre_dni,
        padre_familia.padre_nombres,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat
        FROM
        estudiante
        INNER JOIN padre_familia ON estudiante.id_padre_familia = padre_familia.id_padre_familia
        where id_estudiante=$id");

        $datosPadreFamilia = DB::select("select * from padre_familia order by padre_ape_pat asc");

        return view('vistas/estudiantes.show', compact("datosEstudiante"))->with('datosPadreFamilia', $datosPadreFamilia);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'txtnombre' => 'required',
            'txtapellidopaterno' => 'required',
            'txtapellidomaterno' => 'required',
            'txtdni' => 'required',
            'txtpadrefamilia' => 'required'
        ]);

        //validar que el dni no se repita
        $dni = $request->txtdni;
        $dniRepetido = DB::select("select * from estudiante where dni = ? and id_estudiante!=$id", [$dni]);
        if ($dniRepetido) {
            return redirect()->back()->with('INCORRECTO', 'El DNI ingresado ya existe');
        } else {
            //actualizar datos
            $nombre = $request->txtnombre;
            $apellidoPaterno = $request->txtapellidopaterno;
            $apellidoMaterno = $request->txtapellidomaterno;
            $dni = $request->txtdni;
            $padreFamilia = $request->txtpadrefamilia;

            try {
                $res = DB::update('update estudiante set id_padre_familia = ?, dni = ?, nombres = ?, ape_pat = ?, ape_mat = ? where id_estudiante = ?', [$padreFamilia, $dni, $nombre, $apellidoPaterno, $apellidoMaterno, $id]);
                if ($res == 0) {
                    $res = 1;
                }
            } catch (\Throwable $th) {
                $res = 0;
            }
            if ($res == 1) {
                return redirect()->back()->with('CORRECTO', 'Estudiante actualizado correctamente');
            } else {
                return redirect()->back()->with('INCORRECTO', 'Error al actualizar estudiante');
            }
        }
    }


    public function destroy($id)
    {
        $res = DB::delete('delete from estudiante where id_estudiante = ?', [$id]);
        if ($res) {
            return redirect()->route('estudiantes.index')->with('CORRECTO', 'Estudiante eliminado correctamente');
        } else {
            return redirect()->route('estudiantes.index')->with('INCORRECTO', 'Error al eliminar estudiante');
        }
    }

    public function vacearRegistro()
    {
        $res = DB::delete('delete from estudiante');
        if ($res) {
            return redirect()->route('estudiantes.index')->with('CORRECTO', 'Estudiantes eliminados correctamente');
        } else {
            return redirect()->route('estudiantes.index')->with('INCORRECTO', 'Error al eliminar estudiantes');
        }
    }

    public function modeloEstudianteExcel()
    {
        return Excel::download(new EstudianteExport, 'modeloEstudiante.xlsx'); //csv
    }

    public function importarEstudiantes(Request $request)
    {
        $request->validate([
            'txtfile' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        //validar que el nombre del archivo sea modeloEstudiante
        $nombreArchivo = $request->file('txtfile')->getClientOriginalName();
        if ($nombreArchivo != "modeloEstudiante.xlsx") {
            return redirect()->route('estudiantes.index')->with('INCORRECTO', 'El archivo debe llamarse modeloEstudiante');
        }
        //return "Hola";
        $file = $request->file("txtfile"); //dato es el name
        if (Excel::import(new EstudianteImport(), $file)) {
            return redirect()->route('estudiantes.index')->with('CORRECTO', 'Estudiantes importados correctamente');
        } else {
            return redirect()->route('estudiantes.index')->with('INCORRECTO', 'Error al importar estudiantes');
        }
    }

    public function buscarEstudiante(Request $request)
    {

        $valor = $request->txtdni;
        if ($valor == null) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 400);
        }

        $datosEstudiante = DB::select("SELECT
        estudiante.*,
        padre_familia.padre_dni,
        padre_familia.padre_nombres,
        padre_familia.padre_ape_pat,
        padre_familia.padre_ape_mat
        FROM
        estudiante
        INNER JOIN padre_familia ON estudiante.id_padre_familia = padre_familia.id_padre_familia where dni like '%$valor%' or nombres like '%$valor%' or 
        ape_pat like '%$valor%' or ape_mat like '%$valor%' or padre_dni like '%$valor%' limit 5");

        if ($datosEstudiante) {
            return response()->json([
                "success" => true,
                "data" => $datosEstudiante
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ], 400);
        }
    }

    public function exportarEstudiantes()
    {
        return Excel::download(new EstudianteExport, 'estudiantes.xlsx'); //csv
    }
}
