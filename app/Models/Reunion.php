<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;
    public $table = "reunion";
    public $primaryKey = "id_reunion";
    public $timestamps = false;
    public $fillable = [
        "id_estado_reunion", "titulo", "descripcion", "multa_precio", "fecha", "hora"
    ];
}
