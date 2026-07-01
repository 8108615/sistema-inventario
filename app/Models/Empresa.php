<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Empresa extends Model
{
    protected $fillable = [
        'nombre', 'propietario', 'nit', 'porcentaje_impuesto',
        'abreviatura_impuesto', 'direccion', 'correo', 'telefono',
        'divisa', 'logo', 'web'
    ];

    public function getInfoDivisaAttribute()
    {
        $path = public_path('divisas.json');

        if (!File::exists($path)) return null;

        $json = json_decode(File::get($path), true);

        return $json[$this->divisa] ?? null;
    }
}
