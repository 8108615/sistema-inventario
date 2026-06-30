<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\DB;

class EditarVenta extends Component
{
    public $venta, $cliente_id, $tipo_comprobante, $metodo_pago, $con_impuesto = false;
    public $producto_id, $cantidad = 1, $carrito = [];
    public $clientes, $productos;
    public $monto_recibido = 0;
    public $stock_actual, $precio_venta;

    public function mount($id)
    {
        $this->venta = Venta::with(['detalles.producto', 'cliente'])->findOrFail($id);
        $this->cliente_id = $this->venta->cliente_id;
        $this->tipo_comprobante = $this->venta->tipo_comprobante;
        $this->metodo_pago = $this->venta->metodo_pago;
        $this->monto_recibido = $this->venta->monto_recibido;

        foreach ($this->venta->detalles as $d) {
            $this->carrito[] = [
                'producto_id' => $d->producto_id,
                'nombre' => $d->producto->nombre_producto,
                'cantidad' => $d->cantidad,
                'precio' => $d->precio_unitario,
                'subtotal' => $d->subtotal
            ];
        }
        $this->clientes = \App\Models\Cliente::all();
        $this->productos = Producto::all();
    }

    public function agregarAlCarrito()
    {
        $prod = Producto::find($this->producto_id);
        $this->carrito[] = [
            'producto_id' => $prod->id,
            'nombre' => $prod->nombre_producto,
            'cantidad' => $this->cantidad,
            'precio' => $prod->precio_venta,
            'subtotal' => $prod->precio_venta * $this->cantidad
        ];
    }

    public function eliminarProducto($index)
    {
        unset($this->carrito[$index]);
        $this->carrito = array_values($this->carrito);
    }

    public function actualizarVenta()
    {
        DB::transaction(function () {
            // 1. Devolver stock anterior
            foreach ($this->venta->detalles as $d) {
                Producto::find($d->producto_id)->increment('stock_actual', $d->cantidad);
            }
            // 2. Eliminar detalles antiguos
            DetalleVenta::where('venta_id', $this->venta->id)->delete();

            // 3. Guardar nuevos detalles y descontar stock
            $subtotal = 0;
            foreach ($this->carrito as $item) {
                DetalleVenta::create([
                    'venta_id' => $this->venta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal']
                ]);
                Producto::find($item['producto_id'])->decrement('stock_actual', $item['cantidad']);
                $subtotal += $item['subtotal'];
            }

            $this->venta->update([
                'cliente_id' => $this->cliente_id,
                'tipo_comprobante' => $this->tipo_comprobante,
                'metodo_pago' => $this->metodo_pago,
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'total' => $total,
                'monto_recibido' => $this->monto_recibido, // Guardamos el valor actualizado
                'vuelto_entregado' => $this->monto_recibido - $total,
            ]);
        });

        return redirect()->route('ventas.index');
    }

    public function updatedProductoId($value)
    {
        if ($value) {
            $producto = Producto::find($value);
            $this->stock_actual = $producto->stock_actual;
            $this->precio_venta = $producto->precio_venta;
        } else {
            $this->stock_actual = 0;
            $this->precio_venta = 0;
        }
    }

    public function render()
    {
        return view('livewire.ventas.editar-venta')->layout('layouts.app');
    }
}
