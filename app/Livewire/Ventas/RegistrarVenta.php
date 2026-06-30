<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\{Venta, DetalleVenta, Cliente, Producto, Caja};
use Illuminate\Support\Facades\DB;

class RegistrarVenta extends Component
{
    public $cliente_id, $tipo_comprobante = 'Boleta', $metodo_pago = 'EFECTIVO';
    public $monto_recibido = 0, $carrito = [], $producto_id, $cantidad = 1;
    public $stock_actual, $precio_venta;
    public $con_impuesto = false;

    protected $rules = [
        'cliente_id' => 'required',
        'carrito' => 'required|array|min:1',
    ];

    public function updatedProductoId($value)
    {
        if ($value) {
            $producto = Producto::find($value);
            $this->stock_actual = $producto->stock_actual;
            $this->precio_venta = $producto->precio_venta;
        }
    }

    public function agregarAlCarrito()
    {
        $this->validate(['producto_id' => 'required', 'cantidad' => 'required|min:1']);
        $producto = Producto::findOrFail($this->producto_id);

        if ($producto->stock_actual < $this->cantidad) {
            $this->dispatch('alerta', ['tipo' => 'error', 'mensaje' => 'Stock insuficiente']);
            return;
        }

        $this->carrito[$producto->id] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre_producto,
            'precio' => $producto->precio_venta,
            'cantidad' => $this->cantidad,
            'subtotal' => $producto->precio_venta * $this->cantidad
        ];

        $this->reset(['producto_id', 'cantidad', 'stock_actual', 'precio_venta']);
    }

    public function quitarDelCarrito($productoId)
    {
        if (isset($this->carrito[$productoId])) {
            unset($this->carrito[$productoId]);
        }
    }

    public function registrarVenta()
    {
        $this->validate();

        // 1. Calculamos valores finales ANTES de la transacción para usarlos
        $subtotal = collect($this->carrito)->sum('subtotal');
        $impuesto = ($this->con_impuesto) ? ($subtotal * 0.13) : 0;
        $total = $subtotal + $impuesto;

        DB::transaction(function () use ($subtotal, $impuesto, $total) {
            $caja = Caja::where('estado', true)->first();

            $venta = Venta::create([
                'cliente_id' => $this->cliente_id,
                'user_id' => auth()->id(),
                'caja_id' => $caja->id,
                'tipo_comprobante' => $this->tipo_comprobante,
                'numero_comprobante' => 'V-' . now()->timestamp,
                'metodo_pago' => $this->metodo_pago,
                'fecha_hora' => now(),
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'total' => $total,
                'monto_recibido' => (float)$this->monto_recibido,
                'vuelto_entregado' => max(0, (float)$this->monto_recibido - $total),
            ]);

            foreach ($this->carrito as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);
                Producto::find($item['id'])->decrement('stock_actual', $item['cantidad']);
            }
        });

        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Venta finalizada con éxito']);
        return redirect()->route('ventas.index');
    }

    public function render()
    {
        $subtotal = collect($this->carrito)->sum('subtotal');
        $impuesto = ($this->con_impuesto) ? ($subtotal * 0.13) : 0;
        $total_final = $subtotal + $impuesto;
        $vuelto = max(0, (float)$this->monto_recibido - $total_final);

        return view('livewire.ventas.registrar-venta', [
            'clientes' => Cliente::where('estado', true)->get(),
            'productos' => Producto::where('estado', true)->get(),
            'subtotal' => $subtotal,
            'impuesto' => $impuesto,
            'total' => $total_final,
            'vuelto' => $vuelto
        ]);
    }
}
