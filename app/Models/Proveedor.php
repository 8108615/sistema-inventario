<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre', 'telefono', 'email', 'direccion', 'empresa', 'notas', 'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }

    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class);
    }
}
