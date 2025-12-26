<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_modular',
        'nombre',
        'tipo_ies',
        'dre',
        'direccion',
        'telefono',
        'correo',
        'pagina_web',
        'otros',
        'logo',
    ];
}
