<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use App\Models\{Compra, DetalleCompra, Proveedor, Producto, Sucursal};

class RegistrarCompra extends Component
{
    public $paso = 1;
    public $compra_id;

    // Propiedades de Cabecera (AGREGA $tipo_comprobante AQUÍ)
    public $proveedor_id, $tipo_comprobante, $fecha_compra, $observaciones, $estado = 'pendiente';

    public $producto_id, $lote_id, $cantidad, $precio_unitario, $precio_venta, $fecha_vencimiento;

    // Propiedad de Finalización
    public $sucursal_id;



    public function crearCabecera()
    {
        $this->validate([
            'proveedor_id'     => 'required',
            'fecha_compra'     => 'required|date',
            'tipo_comprobante' => 'required',
        ]);

        $compra = Compra::create([
            'proveedor_id'     => $this->proveedor_id,
            'tipo_comprobante' => $this->tipo_comprobante,
            'fecha_compra'     => $this->fecha_compra,
            'observaciones'    => $this->observaciones,
            'estado'           => 'pendiente',
            'sucursal_id'      => 1,
            'total'            => 0
        ]);

        $this->compra_id = $compra->id;
        $this->paso = 2;
    }

    public function mount()
    {
        $this->fecha_compra = date('Y-m-d');
        $this->tipo_comprobante = 'Factura';
    }

    public function agregarProducto()
    {
        $this->validate([
            'producto_id'     => 'required',
            'cantidad'        => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        DetalleCompra::create([
            'compra_id' => $this->compra_id,
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'lote_id' => $this->lote_id,
            'subtotal' => $this->cantidad * $this->precio_unitario
        ]);

        $this->reset(['producto_id', 'cantidad', 'precio_unitario', 'precio_venta', 'fecha_vencimiento']);
    }

    public function eliminarDetalle($id)
    {
        // Buscamos el detalle y lo eliminamos
        $detalle = DetalleCompra::find($id);
        if ($detalle) {
            $detalle->delete();
            session()->flash('message', 'Producto eliminado de la compra.');
        }
    }

    public function finalizarCompra()
    {
        $this->validate([
            'sucursal_id' => 'required'
        ]);

        // 1. Obtener los detalles actuales
        $detalles = DetalleCompra::where('compra_id', $this->compra_id)->get();

        // 2. Aumentar el stock de cada producto
        foreach ($detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            if ($producto) {
                // Incrementamos el stock actual con la cantidad comprada
                $producto->increment('stock_actual', $detalle->cantidad);
            }
        }

        // 3. Finalizar la cabecera de la compra
        $compra = Compra::find($this->compra_id);
        $compra->update([
            'sucursal_id' => $this->sucursal_id,
            'estado'      => 'recibida', // Asegúrate de que coincida con tu lógica
            'total'       => $detalles->sum('subtotal')
        ]);

        session()->flash('message', 'Compra finalizada y stock actualizado.');
        return redirect()->route('compras.index');
    }

    public function volverAlPasoUno()
    {
        $this->paso = 1;
    }

    public function cancelarCompra()
    {
        if ($this->compra_id) {
            // 1. Eliminamos los detalles asociados primero
            DetalleCompra::where('compra_id', $this->compra_id)->delete();

            // 2. Eliminamos la cabecera
            $compra = Compra::find($this->compra_id);
            if ($compra) {
                $compra->delete();
            }
        }

        // 3. Redirigimos al listado
        return redirect()->route('compras.index');
    }

    public function render()
    {
        return view('livewire.compras.registrar-compra', [
            'proveedores' => Proveedor::all(),
            'productos'   => Producto::all(), // <-- ¡Asegúrate de que esto esté aquí!
            'sucursales'  => Sucursal::all(),
            'detalles'    => $this->compra_id ? DetalleCompra::where('compra_id', $this->compra_id)->get() : []
        ]);
    }


}
