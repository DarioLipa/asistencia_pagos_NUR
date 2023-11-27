<?php

namespace App\Http\Controllers;

use App\Exports\PadreFamiliaExport;
use App\Exports\PadreFamiliaModeloExport;
use App\Imports\PadreFamiliaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SplFileObject;

class PadreFamiliaController extends Controller
{

    public function index()
    {

        $datosPadreFamilia = DB::table('padre_familia')
            ->leftJoin('cargo', 'padre_familia.id_cargo', '=', 'cargo.id_cargo')
            ->leftJoin('tipo_consanguinidad', 'padre_familia.tipo_consanguinidad', '=', 'tipo_consanguinidad.id_tipo_consanguinidad')
            ->select(
                'padre_familia.*',
                'cargo.nombre as cargo',
                'tipo_consanguinidad.nombre as tipo_consanguinidad'
            )
            ->orderBy('padre_familia.id_padre_familia', 'asc')
            ->paginate(10);

        return view('vistas/padres_familia.index', compact("datosPadreFamilia"));
    }


    public function create()
    {
        $cargo = DB::select("select * from cargo order by nombre asc");
        $consanguinidad = DB::select("select * from tipo_consanguinidad");
        return view('vistas/padres_familia.create')->with('cargo', $cargo)->with('consanguinidad', $consanguinidad);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'txtnombre' => 'required',
                'txtapellidopaterno' => 'required',
                'txtapellidomaterno' => 'required',
                'txtdni' => 'required',
                'txttelefono' => 'required',
                'txtcargo' => 'required',
                'txtconsanguinidad' => 'required'
            ]
        );
        //validar que el dni no se repita
        $dni = $request->txtdni;
        $dniRepetido = DB::select('select * from padre_familia where padre_dni = ?', [$dni]);
        if ($dniRepetido) {
            return redirect()->back()->with('INCORRECTO', 'El DNI ingresado ya existe');
        } else {
            //insertar datos
            $nombre = $request->txtnombre;
            $apellidoPaterno = $request->txtapellidopaterno;
            $apellidoMaterno = $request->txtapellidomaterno;
            $dni = $request->txtdni;
            $telefono = $request->txttelefono;
            $cargo = $request->txtcargo;
            $consanguinidad = $request->txtconsanguinidad;
            $direccion = $request->txtdireccion;

            $res = DB::insert('insert into padre_familia (id_cargo, tipo_consanguinidad, padre_dni, padre_nombres, padre_ape_pat, padre_ape_mat, celular, direccion, fecha_creacion) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$cargo, $consanguinidad, $dni, $nombre, $apellidoPaterno, $apellidoMaterno, $telefono, $direccion, date("Y-m-d H:i:s")]);
            if ($res) {
                return redirect()->back()->with('CORRECTO', 'Padre de familia registrado correctamente');
            } else {
                return redirect()->back()->with('INCORRECTO', 'Error al registrar padre de familia');
            }
        }
    }


    public function show($id)
    {
        $datosPadreFamilia = DB::select("SELECT
        padre_familia.*,
        cargo.nombre as cargo ,
        tipo_consanguinidad.nombre as nombre_consanguinidad
        FROM
        padre_familia
        LEFT JOIN cargo ON padre_familia.id_cargo = cargo.id_cargo
        LEFT JOIN tipo_consanguinidad ON padre_familia.tipo_consanguinidad = tipo_consanguinidad.id_tipo_consanguinidad
        where id_padre_familia=$id");

        $cargo = DB::select("select * from cargo order by nombre asc");
        $consanguinidad = DB::select("select * from tipo_consanguinidad");

        $estudiantesACargo = DB::select("select * from estudiante where id_padre_familia=$id");

        return view('vistas/padres_familia.show', compact("datosPadreFamilia"))->with('cargo', $cargo)->with('consanguinidad', $consanguinidad)->with('estudiantesACargo', $estudiantesACargo);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'txtdni' => 'required',
            'txtnombre' => 'required',
            'txtapellidopaterno' => 'required',
            'txtapellidomaterno' => 'required',
            'txtcargo' => 'required',
            'txtconsanguinidad' => 'required'
        ]);

        //validar que el dni no se repita
        $dni = $request->txtdni;
        $dniRepetido = DB::select("select * from padre_familia where padre_dni = ? and id_padre_familia!=$id", [$dni]);
        if ($dniRepetido) {
            return redirect()->back()->with('INCORRECTO', 'El DNI ingresado ya existe');
        } else {
            //actualizar datos
            $nombre = $request->txtnombre;
            $apellidoPaterno = $request->txtapellidopaterno;
            $apellidoMaterno = $request->txtapellidomaterno;
            $dni = $request->txtdni;
            $cargo = $request->txtcargo;
            $consanguinidad = $request->txtconsanguinidad;
            $direccion = $request->txtdireccion;
            $celular = $request->txtcelular;

            try {
                $res = DB::update('update padre_familia set id_cargo = ?, tipo_consanguinidad = ?, padre_dni = ?, padre_nombres = ?, padre_ape_pat = ?, padre_ape_mat = ?, celular = ?, direccion = ? where id_padre_familia = ?', [$cargo, $consanguinidad, $dni, $nombre, $apellidoPaterno, $apellidoMaterno, $celular, $direccion, $id]);
                if ($res == 0) {
                    $res = 1;
                }
            } catch (\Throwable $th) {
                $res = 0;
            }
            if ($res == 1) {
                return redirect()->back()->with('CORRECTO', 'Datos actualizado correctamente');
            } else {
                return redirect()->back()->with('INCORRECTO', 'Error al actualizar los datos');
            }
        }
    }


    public function destroy($id)
    {
        //verificar si el registro que se desea eliminar esta vinculado con otra tabla. si es asi retornar un mensaje
        $res = DB::select('select * from estudiante where id_padre_familia = ?', [$id]);
        if ($res) {
            return redirect()->back()->with('INCORRECTO', 'No se puede eliminar el registro porque esta vinculado con la tabla Estudiante');
        }

        $res = DB::delete('delete from padre_familia where id_padre_familia = ?', [$id]);
        if ($res) {
            return redirect()->route("padres-familia.index")->with('CORRECTO', 'Padre de familia eliminado correctamente');
        } else {
            return redirect()->route("padres-familia.index")->with('INCORRECTO', 'Error al eliminar Padre de familia');
        }
    }

    public function vacearRegistro()
    {
        //verificar si el registro que se desea esta vinculado con otra tabla. si es asi retornar un mensaje
        $res = DB::select('select * from estudiante');
        if ($res) {
            return redirect()->back()->with('AVISO', 'No se puede vaciar la tabla porque tiene registros vinculados con la tabla Estudiante. Si deseas eliminar todo el registro Primero debes eliminar todos los Estudiantes');
        }

        $res = DB::delete('delete from padre_familia');
        if ($res) {
            return redirect()->back()->with('CORRECTO', 'Padres de familia eliminados correctamente');
        } else {
            return redirect()->back()->with('INCORRECTO', 'Error al eliminar Padres de familia');
        }
    }


    public function importarPadresFamilia(Request $request)
    {
        $request->validate([
            'txtfile' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        //validar que el nombre del archivo sea modeloPadreFamilia
        $nombreArchivo = $request->file('txtfile')->getClientOriginalName();
        if ($nombreArchivo != "modeloPadreFamilia.xlsx") {
            return redirect()->back()->with('INCORRECTO', 'El archivo debe llamarse modeloPadreFamilia');
        }

        $file = $request->file("txtfile"); //dato es el name
        if (Excel::import(new PadreFamiliaImport(), $file)) {
            return redirect()->back()->with('CORRECTO', 'Padres de familia importados correctamente');
        } else {
            return redirect()->back()->with('INCORRECTO', 'Error al importar Padres de familia');
        }
    }

    public function buscarPadreFamilia(Request $request)
    {

        $valor = $request->txtdni;
        if ($valor == null) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 400);
        }

        $datosPadreFamilia = DB::select("SELECT
        padre_familia.*,
        cargo.nombre as cargo ,
        tipo_consanguinidad.nombre as tipo_consanguinidad
        FROM
        padre_familia
        LEFT JOIN cargo ON padre_familia.id_cargo = cargo.id_cargo
        LEFT JOIN tipo_consanguinidad ON padre_familia.tipo_consanguinidad = tipo_consanguinidad.id_tipo_consanguinidad where padre_dni like '%$valor%' or padre_nombres like '%$valor%' or 
        padre_ape_pat like '%$valor%' or padre_ape_mat like '%$valor%' limit 5");

        if ($datosPadreFamilia) {
            return response()->json([
                "success" => true,
                "data" => $datosPadreFamilia
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ], 400);
        }
    }

    public function exportarPadresFamilia()
    {
        return Excel::download(new PadreFamiliaExport, 'Padres de familia.xlsx'); //csv
    }

    public function exportarPadresFamiliaModelo()
    {
        return Excel::download(new PadreFamiliaModeloExport, 'modeloPadreFamilia.xlsx'); //csv
    }

    //controlador para descargar la tarjeta del padre de familia por unidad
    public function tarjeta($id_padre)
    {
        $empresa = DB::select('select * from empresa');

        $datosPadreFamilia = DB::select(" SELECT
        padre_familia.*,
        cargo.nombre,
        tipo_consanguinidad.nombre as nombre_consanguinidad
        FROM
        padre_familia
        LEFT JOIN cargo ON padre_familia.id_cargo = cargo.id_cargo
        LEFT JOIN tipo_consanguinidad ON padre_familia.tipo_consanguinidad = tipo_consanguinidad.id_tipo_consanguinidad
        where id_padre_familia=$id_padre ");

        $nombrePadre = $datosPadreFamilia[0]->padre_nombres;

        $datosEstudiante = DB::select(" SELECT
        estudiante.*
        FROM
        estudiante
         where id_padre_familia=$id_padre ");

        foreach ($datosPadreFamilia as $key => $item) {
            //generar el qr
            QrCode::format('png')->size(500)->generate($item->padre_dni, public_path("qr/$id_padre.png"));
            //qr de historial padres
            QrCode::format('png')->size(500)->generate(route("historial.descargaPDF", $item->padre_dni), public_path("qr/historial/$id_padre.png"));
        }


        //$image = new SplFileObject(public_path("qr/prueba.png"));

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper([0, 0, 105, 148], 'portrait');
        //poner tamaño a4 vertical
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadView('vistas/padres_familia/tarjetaPersonalPadreFamilia', compact("datosPadreFamilia", "datosEstudiante", "empresa", "id_padre"));
        return $pdf->stream("$nombrePadre-tarjeta-apafa.pdf");
    }

    public function descargarTarjeta($pagina)
    {
        $empresa = DB::select('select * from empresa');

        $datosPadreFamilia = DB::table('padre_familia')
            ->leftJoin('cargo', 'padre_familia.id_cargo', '=', 'cargo.id_cargo')
            ->leftJoin('tipo_consanguinidad', 'padre_familia.tipo_consanguinidad', '=', 'tipo_consanguinidad.id_tipo_consanguinidad')
            ->select('padre_familia.*', 'cargo.nombre', 'tipo_consanguinidad.nombre as nombre_consanguinidad')
            ->orderBy('padre_familia.id_padre_familia', 'asc')
            ->paginate(10, ['*'], 'pagina', $pagina);

        $datosEstudiante = DB::select(" SELECT
        estudiante.*
        FROM
        estudiante ");

        //generar el qr
        foreach ($datosPadreFamilia as $key => $value) {

            //crear el qr solo si no existe
            if (!file_exists(public_path("qr/$value->id_padre_familia.png"))) {
                QrCode::format('png')->size(300)->generate($value->padre_dni, public_path("qr/$value->id_padre_familia.png"));
            }

            // crear qr de historial padres solo si no existe
            if (!file_exists(public_path("qr/historial/$value->id_padre_familia.png"))) {
                QrCode::format('png')->size(300)->generate(route("historial.descargaPDF", $value->padre_dni), public_path("qr/historial/$value->id_padre_familia.png"));
            }
        }
        //$image = new SplFileObject(public_path("qr/prueba.png"));

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper([0, 0, 105, 148], 'portrait');
        //poner tamaño a4 vertical
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadView('vistas/padres_familia/tarjetasPadreFamilia', compact("datosPadreFamilia", "datosEstudiante", "empresa"));
        return $pdf->download("tarjetas-apafa.pdf");
    }

    public function buscarPadres($dni)
    {
        $totalPadre = DB::select("SELECT COUNT(*) as cantidad FROM padre_familia WHERE padre_dni=?", [$dni]);
        if ($totalPadre[0]->cantidad == 0) {
            return response()->json([
                "success" => false,
                "data" => ["mensaje" => "El padre de familia no existe"]
            ], 400);
        } else {
            return response()->json([
                "success" => true,
                "data" => $totalPadre[0]->cantidad
            ], 200);
        }
    }
}
