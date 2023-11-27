<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aporte extends Model
{
    use HasFactory;
    public $table = "aporte";
    protected $primaryKey = "id_aporte";
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'descripcion',
        'monto',
        'fecha',
    ];
}
