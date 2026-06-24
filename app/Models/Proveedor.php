<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre', 'telefono', 'email', 'direccion', 'empresa', 'notas', 'estado'
    ];
    
    protected $casts = [
    'estado' => 'boolean',
];
}
