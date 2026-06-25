<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id', 'codigo_producto', 'codigo_barra', 'nombre_producto',
        'descripcion', 'imagen', 'precio_compra', 'precio_venta',
        'stock_actual', 'stock_minimo', 'stock_maximo', 'unidad_medida', 'estado'
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
