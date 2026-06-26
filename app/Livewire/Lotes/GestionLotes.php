<?php

namespace App\Livewire\Lotes;

use Livewire\Component;
use App\Models\Lote;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GestionLotes extends Component
{
    use WithPagination;

    public $loteSeleccionado = null;
    public $isVerOpen = false;
    public $search = '';
    protected $paginationTheme = 'tailwind';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Filtramos los lotes basándonos en el valor de $this->search
        $lotes = Lote::with(['producto', 'proveedor'])
            ->where(function($query) {
                $query->where('codigo_lote', 'like', '%' . $this->search . '%')
                      ->orWhereHas('producto', function($q) {
                          $q->where('nombre_producto', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('proveedor', function($q) {
                          $q->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('empresa', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.lotes.gestion-lotes', compact('lotes'));
    }

    public function verDetalle($id)
    {
        $this->loteSeleccionado = Lote::with(['producto', 'proveedor'])->find($id);
        $this->isVerOpen = true;
    }

    public function confirmarEliminacion($id)
    {
        $lote = Lote::findOrFail($id);

        $this->dispatch('confirmar-eliminacion', [
            'id' => $lote->id,
            'nombre' => 'Lote ' . $lote->codigo_lote
        ]);
    }

    // 2. Método que recibe la confirmación desde JS
    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();

        // Lanzar alerta de éxito
        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Lote eliminado correctamente'
        ]);
    }


}
