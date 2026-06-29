<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use App\Models\Compra;

class DetalleCompra extends Component
{
    public $compra;

    public function mount($id)
    {
        // Cargamos la compra con todas sus relaciones
        $this->compra = Compra::with(['proveedor', 'sucursal', 'detalles.producto'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.compras.detalle-compra');
    }
}
