<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ListadoProductos extends Component
{
    use WithPagination;

    public $search = '';

    // Escucha el evento que viene desde SweetAlert
    protected $listeners = ['eliminar-confirmado' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
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

    // 1. Dispara el SweetAlert de confirmación
    public function confirmarEliminar($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            // Enviamos el ID y el NOMBRE para que el script de SweetAlert pueda mostrarlo
            $this->dispatch('confirmar-eliminacion', [
                'id' => $id,
                'nombre' => $producto->nombre_producto
            ]);
        }
    }


    // 2. Ejecuta el borrado real
    public function delete($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            // Borrar imagen del almacenamiento
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->delete();

            // Disparamos alerta de éxito
            $this->dispatch('alerta', tipo: 'success', mensaje: 'Producto eliminado correctamente');
        }
    }
}
