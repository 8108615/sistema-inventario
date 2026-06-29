<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_cliente',
        'tipo_persona',
        'razon_social',
        'nit',
        'direccion',
        'telefono',
        'email',
        'tipo_documento',
        'numero_documento',
        'estado'
    ];
}
