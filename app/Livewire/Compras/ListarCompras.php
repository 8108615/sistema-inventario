<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use App\Models\Compra;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ListarCompras extends Component
{
    use WithPagination;

    public $search = ''; // Variable para el buscador

    // Al buscar, reinicia la paginación a la página 1
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmarEliminacion($id, $nombre)
    {
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => $nombre
        ]);
    }


    #[On('eliminar-confirmado')]
    public function destroy($id)
    {
        $compra = Compra::with('detalles')->find($id);

        if ($compra) {
            // 1. Revertir el stock_actual de cada producto relacionado
            foreach ($compra->detalles as $detalle) {
                $producto = \App\Models\Producto::find($detalle->producto_id);
                if ($producto) {
                    // Usamos 'stock_actual' en lugar de 'stock'
                    $producto->stock_actual -= $detalle->cantidad;
                    $producto->save();
                }
            }

            // 2. Eliminar detalles y cabecera
            $compra->detalles()->delete();
            $compra->delete();

            $this->dispatch('alerta', [
                'tipo' => 'success',
                'mensaje' => 'Compra eliminada y stock actualizado correctamente'
            ]);
        }
    }

    public function render()
    {
        // Cargamos la relación 'detalles' y 'detalles.producto' para evitar consultas N+1
        $compras = Compra::with(['proveedor', 'sucursal', 'detalles.producto'])
            ->whereHas('proveedor', function($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.compras.listar-compras', [
            'compras' => $compras
        ]);
    }
}
