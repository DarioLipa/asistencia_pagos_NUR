<?php

namespace App\Http\Controllers;

use App\Exports\reunionReporteExport;
use App\Models\Reunion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReunionController extends Controller
{

    public function index()
    {
        $reuniones = Reunion::select('reunion.*', DB::raw('(SELECT COUNT(*) FROM reunion_padres WHERE reunion_padres.id_reunion = reunion.id_reunion) as total'), 'estado_reunion.estado')
            ->join('estado_reunion', 'reunion.id_estado_reunion', '=', 'estado_reunion.id_estado_reunion')
            ->orderBy('reunion.id_reunion', 'desc')
            ->paginate(10);

        $estadoReunion = DB::select("select * from estado_reunion");



        //$reunion_padres = DB::select("select * from reunion_padres");
        $totalParticipantes = DB::select("SELECT
        Count(*),
        reunion_padres.id_reunion,
        reunion.titulo
        FROM
        reunion_padres
        INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
        GROUP BY id_reunion
        ");

        return view("vistas/reuniones.index", compact("reuniones"))->with("estado", $estadoReunion)->with("totalParticipantes", $totalParticipantes);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            "txttitulo" => "required",
            "txtdescripcion" => "required",
            "txtmulta" => "required",
            "txtfecha" => "required",
            "txthora" => "required",
            "txtestado" => "required",
        ]);
        //registrar
        $reunion = new Reunion();
        $reunion->id_estado_reunion = $request->txtestado;
        $reunion->titulo = $request->txttitulo;
        $reunion->descripcion = $request->txtdescripcion;
        $reunion->multa_precio = $request->txtmulta;
        $reunion->fecha = $request->txtfecha;
        $reunion->hora = $request->txthora;
        $reunion->save();

        //redireccionar a la vista de agregar participantes 
        return redirect()->route("reuniones.vistaAgregarParticipante", $reunion->id_reunion)->with("CORRECTO", "Reunion registrada exitosamente");
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            "txttitulo" => "required",
            "txtdescripcion" => "required",
            "txtmulta" => "required",
            "txtfecha" => "required",
            "txthora" => "required",
            "txtestado" => "required",
        ]);
        //modificar
        $reunion = Reunion::findOrFail($id);
        $reunion->id_estado_reunion = $request->txtestado;
        $reunion->titulo = $request->txttitulo;
        $reunion->descripcion = $request->txtdescripcion;
        $reunion->multa_precio = $request->txtmulta;
        $reunion->fecha = $request->txtfecha;
        $reunion->hora = $request->txthora;
        $reunion->save();
        return redirect()->route("reuniones.index")->with("CORRECTO", "Reunion modificada exitosamente");
    }


    public function destroy($id)
    {
        //eliminar
        // verificar si la reunion tiene participantes
        // $participantes = DB::select("SELECT * FROM reunion_padres WHERE id_reunion = ?", [$id]);
        // if (count($participantes) > 0) {
        //     return back()->with("INCORRECTO", "No se puede eliminar la reunión porque tiene participantes vinculados");
        // }

        $reunion = Reunion::findOrFail($id);
        $reunion->delete();
        return redirect()->route("reuniones.index")->with("CORRECTO", "Reunion eliminada exitosamente");
    }

    public function addParticipante(Request $request)
    {
        $request->validate([
            "txtidreunion" => "required",
            "txtidparticipante" => "required",
        ]);

        $idParticipantes = explode(",", $request->txtidparticipante);
        //insertar cada participante en la tabla reunion_padres
        foreach ($idParticipantes as $idParticipante) {
            //verificar si ya existe el participante en la reunion
            $existe = DB::select("SELECT * FROM reunion_padres WHERE id_reunion = ? AND id_padre_familia = ?", [$request->txtidreunion, $idParticipante]);
            if (count($existe) <= 0) {
                DB::insert("INSERT INTO reunion_padres (id_reunion, id_padre_familia) VALUES (?, ?)", [$request->txtidreunion, $idParticipante]);
            }
        }

        return back()->with("CORRECTO", "Participantes agregados exitosamente");
    }


    public function vistaAgregarParticipante($id_reunion)
    {

        $reunion = DB::select("SELECT * FROM reunion WHERE id_reunion = ?", [$id_reunion]);

        //aqui se obtiene un si. si los participantes ya estan vinculados a la reunion caso contrario no
        $padresFamilia = DB::select(" SELECT
            padre_familia.*,
            cargo.nombre AS cargo,
            tipo_consanguinidad.nombre AS nombre_consanguinidad,
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM reunion_padres
                    WHERE reunion_padres.id_padre_familia = padre_familia.id_padre_familia
                    AND reunion_padres.id_reunion = $id_reunion
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

        return view("vistas/reuniones.agregarParticipante", compact("padresFamilia"))->with("id_reunion", $id_reunion)->with("reunion", $reunion);
    }


    public function eliminarParticipante($id_reunion)
    {
        //eliminar
        $eliminar = DB::delete("delete from reunion_padres where id_reunion = ?", [$id_reunion]);
        return back()->with("CORRECTO", "Participantes eliminados exitosamente");
    }

    public function reunionesReporte($id_reunion)
    {
        $padresNoAsistidos = DB::select(" SELECT
            padre_familia.padre_dni,
            padre_familia.padre_nombres,
            padre_familia.padre_ape_pat,
            padre_familia.padre_ape_mat,
            padre_familia.celular,
            reunion_padres.asistencia,
            reunion_padres.detalles,
            reunion.titulo,
            reunion.descripcion,
            reunion.multa_precio,
            reunion.fecha,
            reunion.hora
            FROM
            padre_familia
            INNER JOIN reunion_padres ON reunion_padres.id_padre_familia = padre_familia.id_padre_familia
            INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
            where reunion.id_reunion = $id_reunion and (asistencia is null and detalles is null) order by padre_familia.padre_ape_pat asc
        ");

        $padresAsistidos = DB::select(" SELECT
            padre_familia.padre_dni,
            padre_familia.padre_nombres,
            padre_familia.padre_ape_pat,
            padre_familia.padre_ape_mat,
            padre_familia.celular,
            reunion_padres.asistencia,
            reunion_padres.detalles,
            reunion.titulo,
            reunion.descripcion,
            reunion.multa_precio,
            reunion.fecha,
            reunion.hora
            FROM
            padre_familia
            INNER JOIN reunion_padres ON reunion_padres.id_padre_familia = padre_familia.id_padre_familia
            INNER JOIN reunion ON reunion_padres.id_reunion = reunion.id_reunion
            where reunion.id_reunion = $id_reunion and (asistencia is not null or detalles is not null) order by padre_familia.padre_ape_pat asc
        ");

        $tituloReunion = DB::select("SELECT titulo FROM reunion WHERE id_reunion = ?", [$id_reunion]);

        $sumaTotalNoAdeudados = DB::select("SELECT
        sum(reunion.multa_precio) as 'sumaTotalNoAdeudados'
        FROM
        reunion
        INNER JOIN reunion_padres ON reunion_padres.id_reunion = reunion.id_reunion
        where reunion.id_reunion = ? and (asistencia is not null or detalles is not null)", [$id_reunion]);

        $sumaTotalAdeudados = DB::select("SELECT
        sum(reunion.multa_precio) as 'sumaTotalAdeudados'
        FROM
        reunion
        INNER JOIN reunion_padres ON reunion_padres.id_reunion = reunion.id_reunion
        where reunion.id_reunion = ? and (asistencia is null and detalles is null)", [$id_reunion]);

        $sumaTotal = $sumaTotalNoAdeudados[0]->sumaTotalNoAdeudados + $sumaTotalAdeudados[0]->sumaTotalAdeudados;

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes/reporte_reuniones', compact('padresNoAsistidos', "padresAsistidos", "tituloReunion", "sumaTotalNoAdeudados", "sumaTotalAdeudados", "sumaTotal"));
        return $pdf->stream("reporte de reuniones.pdf");
    }

    public function reunionesReporteExcel($id_aporte)
    {
        return Excel::download(new reunionReporteExport($id_aporte), "reunionReporte.xlsx");
    }
}
