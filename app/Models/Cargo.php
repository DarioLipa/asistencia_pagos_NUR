<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    public $table="cargo";
    public $primaryKey="id_cargo";
    public $timestamps=false;
    protected $fillable = [
        'nombre_cargo',
    ];

}
