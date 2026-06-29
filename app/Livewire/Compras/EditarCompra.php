<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use App\Models\{Compra, DetalleCompra, Proveedor, Producto, Sucursal};


class EditarCompra extends Component
{
    public $compra_id, $compra;
    public $paso = 2; // Empezamos directamente en paso 2 porque la cabecera ya existe

    // Propiedades de cabecera
    public $proveedor_id, $tipo_comprobante, $fecha_compra, $observaciones, $sucursal_id;

    // Propiedades para agregar productos
    public $producto_id, $cantidad, $precio_unitario;

    public function mount($id)
    {
        $this->compra_id = $id;
        $this->compra = Compra::with('detalles')->findOrFail($id);

        // Cargar datos actuales
        $this->proveedor_id = $this->compra->proveedor_id;
        $this->tipo_comprobante = $this->compra->tipo_comprobante;
        $this->fecha_compra = $this->compra->fecha_compra;
        $this->observaciones = $this->compra->observaciones;
        $this->sucursal_id = $this->compra->sucursal_id;
    }

    public function agregarProducto()
    {
        // 1. Crear el detalle
        $detalle = DetalleCompra::create([
            'compra_id' => $this->compra_id,
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'subtotal' => $this->cantidad * $this->precio_unitario
        ]);

        // 2. Sumar stock al producto
        $producto = Producto::find($this->producto_id);
        if ($producto) {
            $producto->increment('stock_actual', $this->cantidad);
        }

        $this->reset(['producto_id', 'cantidad', 'precio_unitario']);
    }

    public function eliminarDetalle($id)
    {
        $detalle = DetalleCompra::find($id);
        if ($detalle) {
            // Revertir stock al eliminar
            $producto = Producto::find($detalle->producto_id);
            if ($producto) {
                $producto->decrement('stock_actual', $detalle->cantidad);
            }
            $detalle->delete();
        }
    }

    public function render()
    {
        return view('livewire.compras.editar-compra', [
            'proveedores' => Proveedor::all(),
            'productos'   => Producto::all(),
            'sucursales'  => Sucursal::all(),
            'detalles'    => DetalleCompra::where('compra_id', $this->compra_id)->get()
        ]);
    }

    public function actualizarCompra()
    {
        // 1. Validar cabecera (opcional, pero recomendado)
        $this->validate([
            'proveedor_id' => 'required',
            'fecha_compra' => 'required|date',
        ]);

        // 2. Actualizar la cabecera de la compra
        $this->compra->update([
            'proveedor_id' => $this->proveedor_id,
            'tipo_comprobante' => $this->tipo_comprobante,
            'fecha_compra' => $this->fecha_compra,
            'observaciones' => $this->observaciones,
            'sucursal_id' => $this->sucursal_id,
        ]);

        // Nota: Si el stock ya se sumó al momento de usar agregarProducto(),
        // no necesitas volver a sumarlo aquí.
        // Si no, debes decidir: ¿El stock se suma al agregar o al finalizar?

        session()->flash('message', 'Compra actualizada correctamente.');
        return redirect()->route('compras.index');
    }
}
