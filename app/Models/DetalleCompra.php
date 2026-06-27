<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    protected $guarded = [];

    // Relación: Un detalle pertenece a una compra
    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    // Relación: Un detalle pertenece a un producto
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación: Un detalle pertenece a un lote (el que se generó o actualizó)
    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }
}
