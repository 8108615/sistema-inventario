<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'producto_id', 'proveedor_id', 'codigo_lote', 'fecha_entrada',
        'fecha_vencimiento', 'cantidad_inicial', 'cantidad_actual',
        'precio_compra', 'precio_venta', 'estado'
    ];

    // Relación: Un lote pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación: Un lote pertenece a un proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
