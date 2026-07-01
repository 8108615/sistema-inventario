<?php

namespace App\Livewire\Lotes;

use Livewire\Component;
use App\Models\Lote;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

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
        // 1. Obtener la configuración de la empresa y su divisa
        $empresa = \App\Models\Empresa::first();
        $simboloMoneda = '$';

        // 2. Cargar el símbolo desde divisas.json
        $path = public_path('divisas.json');
        if (File::exists($path)) {
            $divisas = json_decode(File::get($path), true);
            if ($empresa && isset($divisas[$empresa->divisa])) {
                $simboloMoneda = $divisas[$empresa->divisa]['symbol'];
            }
        }

        $lotes = Lote::with(['producto', 'proveedor'])
            // ... (tu lógica de consulta se mantiene igual)
            ->latest()
            ->paginate(10);

        return view('livewire.lotes.gestion-lotes', compact('lotes', 'simboloMoneda'));
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
