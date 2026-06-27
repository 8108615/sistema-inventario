<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{
    protected $guarded = [];

    // Relación: Una compra pertenece a un proveedor
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación: Una compra pertenece a una sucursal
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Relación: Una compra tiene muchos detalles
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
