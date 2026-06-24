<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;

class VerProducto extends Component
{
    public $producto;

    public function mount(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function render()
    {
        return view('livewire.productos.ver-producto')->layout('layouts.app');
    }
}
