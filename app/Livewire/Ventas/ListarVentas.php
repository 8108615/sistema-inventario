<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;

class ListarVentas extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // Cargamos las relaciones para poder acceder a los nombres
        $ventas = Venta::with(['cliente', 'user', 'caja'])
            ->where('numero_comprobante', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.ventas.listar-ventas', compact('ventas'));
    }

    public function verificarCajaYRedirigir()
    {
        $cajaAbierta = \App\Models\Caja::where('estado', true)->exists();

        if (!$cajaAbierta) {
            // Disparamos el evento de confirmación para llevarlo a Cajas
            $this->dispatch('confirmar-accion', [
                'titulo' => 'Caja Cerrada',
                'mensaje' => 'Debes aperturar una caja para realizar ventas. ¿Ir a Cajas ahora?',
                'colorConfirm' => '#3b82f6', // Azul (estilo Tailwind blue-600)
                'textoConfirm' => 'Sí, ir a Cajas',
                'evento' => 'redirigir-a-cajas' // Nombre del evento que escuchará el JS
            ]);
        } else {
            return redirect()->route('ventas.registrar');
        }
    }

    // Escuchamos el evento que viene desde el SweetAlert
    protected $listeners = ['redirigir-a-cajas' => 'irACajas'];

    public function irACajas()
    {
        return redirect()->route('cajas.index');
    }
}
