<?php

namespace App\Imports;

use App\Models\Estudiante;
use App\Models\PadreFamilia;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudianteImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $dnisProcesados = [];
    public function model(array $row)
    {
        try {
            // Verificar duplicados en dni_del_estudiante
            $dniEstudiante = $row['dni_del_hijo'];
            if (in_array($dniEstudiante, $this->dnisProcesados)) {
                // Si el DNI ya ha sido procesado, no se procesa el registro
                return null;
            }
            $this->dnisProcesados[] = $dniEstudiante;

            $duplicadoEstudiante = Estudiante::where('dni', $dniEstudiante)->first();
            if ($duplicadoEstudiante) {
                // Si el DNI ya existe en la base de datos, no se procesa el registro
                return null;
            }

            // Buscar el id del padre de familia según el dni ingresado
            $dniPadre = $row['dni_del_padre_de_familia'];
            $padreFamilia = PadreFamilia::where('padre_dni', $dniPadre)->first();

            // Si el id del padre de familia no se encuentra, registrar un nuevo registro en la tabla padre_familia
            if (!$padreFamilia) {
                $padreFamilia = new PadreFamilia();
                $padreFamilia->padre_dni = $dniPadre;
                $padreFamilia->padre_nombres = $row['nombres_del_padre_de_familia'];
                $padreFamilia->padre_ape_pat = $row['apellido_paterno_del_padre_de_familia'];
                $padreFamilia->padre_ape_mat = $row['apellido_materno_del_padre_de_familia'];
                $padreFamilia->save();
            }

            // Usar el id del padre de familia para el registro del estudiante
            return new Estudiante([
                'id_padre_familia' => $padreFamilia->id_padre_familia,
                'dni' => $dniEstudiante,
                'nombres' => $row['nombres_del_hijo'],
                'ape_pat' => $row['apellido_paterno_del_hijo'],
                'ape_mat' => $row['apellido_materno_del_hijo'],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }
}
