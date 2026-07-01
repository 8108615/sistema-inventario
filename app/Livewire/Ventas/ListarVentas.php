<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Producto;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;

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
        // Lógica para obtener el símbolo de moneda
        $empresa = \App\Models\Empresa::first();
        $simboloMoneda = '$';

        $path = public_path('divisas.json');
        if (File::exists($path)) {
            $divisas = json_decode(File::get($path), true);
            if ($empresa && isset($divisas[$empresa->divisa])) {
                $simboloMoneda = $divisas[$empresa->divisa]['symbol'];
            }
        }

        $ventas = Venta::with(['cliente', 'user', 'caja'])
            ->where(function ($query) {
                $query->where('numero_comprobante', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_hora', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('nombre_cliente', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.ventas.listar-ventas', [
            'ventas' => $ventas,
            'simboloMoneda' => $simboloMoneda
        ]);
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

    public function confirmarEliminacion($id, $numero)
    {
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => 'la Venta Nro. ' . $numero // Nombre para el mensaje de confirmación
        ]);
    }

    #[On('eliminar-confirmado')]
    public function destroy($id)
    {
        $venta = Venta::with('detalles')->find($id);

        if ($venta) {
            // 1. Revertir el stock: al eliminar una venta, los productos regresan al inventario
            foreach ($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if ($producto) {
                    $producto->increment('stock_actual', $detalle->cantidad);
                }
            }

            // 2. Eliminar detalles y la cabecera
            $venta->detalles()->delete();
            $venta->delete();

            $this->dispatch('alerta', [
                'tipo' => 'success',
                'mensaje' => 'Venta eliminada y stock actualizado correctamente'
            ]);
        }
    }

    // Escuchamos el evento que viene desde el SweetAlert
    protected $listeners = ['redirigir-a-cajas' => 'irACajas'];

    public function irACajas()
    {
        return redirect()->route('cajas.index');
    }
}
