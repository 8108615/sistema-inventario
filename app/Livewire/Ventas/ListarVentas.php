<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;

class ListarVentas extends Component
{
    use WithPagination;

    public $search = '';

    public $ventaSeleccionada;
    public $verDetalleModal = false;

    public function limpiar()
    {
        $this->reset('search');
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reinicia la paginación al buscar
    }


    public function verDetalle($ventaId)
    {
        // Cargamos la venta con sus relaciones y el detalle (productos)
        $this->ventaSeleccionada = \App\Models\Venta::with(['cliente', 'user', 'caja', 'detalles.producto'])
            ->find($ventaId);

        $this->verDetalleModal = true;
    }

    public function cerrarModal()
    {
        $this->verDetalleModal = false;
        $this->ventaSeleccionada = null;
    }

    public function render()
    {
        $ventas = Venta::with(['cliente', 'user', 'caja'])
            ->where(function ($query) {
                $query->where('numero_comprobante', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_hora', 'like', '%' . $this->search . '%')
                    // Buscar por nombre de cliente
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('nombre_cliente', 'like', '%' . $this->search . '%');
                    })
                    // Buscar por nombre de usuario
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
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
