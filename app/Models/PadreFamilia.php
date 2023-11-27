<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadreFamilia extends Model
{
    use HasFactory;
    public $table = "padre_familia";
    public $primaryKey = "id_padre_familia";
    public $timestamps = false;
    public $fillable = [
        'id_cargo',
        'tipo_consanguinidad',
        'padre_dni',
        'padre_nombres',
        'padre_ape_pat',
        'padre_ape_mat',
        'celular',
        'direccion',
        'fecha_creacion'
    ];
}
