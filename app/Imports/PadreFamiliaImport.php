<?php

namespace App\Imports;

use App\Models\PadreFamilia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PadreFamiliaImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $dnisProcesados = [];
    public function model(array $row)
    {
        $fechaActual = date('Y-m-d H:i:s');

        $padre_dni = $row["dni"];
        if (in_array($padre_dni, $this->dnisProcesados)) {
            // Si el DNI ya ha sido procesado, no se procesa el registro
            return null;
        }
        $this->dnisProcesados[] = $padre_dni;

        // Verificar duplicados en la base de datos
        $duplicadoPadreFamilia = PadreFamilia::where('padre_dni', $padre_dni)->first();
        if ($duplicadoPadreFamilia) {
            // Si el DNI ya existe en la base de datos, no se procesa el registro
            return null;
        }

        //si el dni esta vacio no se registra
        if ($row["dni"] == null) {
            return null;
        }

        // Usar el id del padre de familia para el registro del estudiante
        return new PadreFamilia([
            'id_cargo' => $row['id_cargoingresa_el_codigo'],
            'tipo_consanguinidad' => $row['consanguinidadingresa_el_codigo'],
            'padre_dni' => $row['dni'],
            'padre_nombres' => $row['nombres'],
            'padre_ape_pat' => $row['apellido_paterno'],
            'padre_ape_mat' => $row['apellido_materno'],
            'celular' => $row['celular'],
            'direccion' => $row['direccion'],
            'fecha_creacion' => $fechaActual,
        ]);
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
