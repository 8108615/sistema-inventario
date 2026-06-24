<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoProductos extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage(); // Resetear a la página 1 al buscar
    }

    public function render()
    {
        $productos = Producto::where('nombre_producto', 'like', '%' . $this->search . '%')
            ->orWhere('codigo_producto', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.productos.listado-productos', compact('productos'))
            ->layout('layouts.app');
    }

    public function confirmarEliminar($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $producto->delete();
            // Opcional: podrías agregar un mensaje de éxito aquí
        }
    }


}
