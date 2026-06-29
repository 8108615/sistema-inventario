<?php

namespace App\Livewire\Cajas;

use Livewire\Component;
use App\Models\Caja;

class DetalleCaja extends Component
{
    public $caja;

    public function mount($id)
    {
        // Cargamos la caja con su usuario relacionado
        $this->caja = Caja::with('user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.cajas.detalle-caja');
    }
}
