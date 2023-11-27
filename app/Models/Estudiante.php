<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    public $table = "estudiante";
    public $primaryKey = "id_estudiante";
    public $timestamps = false;
    protected $fillable = [
        'id_padre_familia',
        'dni',
        'nombres',
        'ape_pat',
        'ape_mat'
    ];
}
