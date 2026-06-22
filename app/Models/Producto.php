<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'imagen',
        'precio_compra',
        'precio_venta',
        'stock_minimo',
        'stock_maximo',
        'unidad_medida',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
