<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caja extends Model
{
    protected $fillable = [
        'nombre_caja',
        'fecha_hora_apertura',
        'fecha_hora_cierre',
        'saldo_inicial',
        'saldo_final',
        'estado',
        'user_id'
    ];

    // Relación con el usuario que abrió la caja
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
