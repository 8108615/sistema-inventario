<?php

namespace App\Livewire\Compras;

use Livewire\Component;
use App\Models\{Proveedor, Sucursal, Producto, Compra, DetalleCompra};
use Illuminate\Support\Facades\DB;

class RegistrarCompra extends Component
{
    // Campos de la tabla compras
    public $proveedor_id, $sucursal_id, $numero_factura, $observaciones, $fecha_compra, $estado = 'recibida';
    public $total = 0;

    // Variables para items
    public $producto_id, $cantidad = 1, $precio;
    public $items = [];

    public function mount() {
        $this->fecha_compra = date('Y-m-d');
    }

    public function agregarItem()
    {
        $this->validate([
            'producto_id' => 'required',
            'cantidad' => 'required|numeric|min:1',
            'precio' => 'required|numeric|min:0',
        ]);

        $producto = Producto::find($this->producto_id);

        $this->items[] = [
            'id' => $producto->id,
            'nombre' => $producto->nombre_producto,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'subtotal' => $this->cantidad * $this->precio
        ];

        $this->calcularTotal();
        $this->reset(['producto_id', 'cantidad', 'precio']);
    }

    public function calcularTotal() {
        $this->total = array_sum(array_column($this->items, 'subtotal'));
    }

    public function guardarCompra()
    {
        $this->validate([
            'proveedor_id' => 'required',
            'sucursal_id' => 'required',
            'numero_factura' => 'required',
        ]);

        DB::transaction(function () {
            $compra = Compra::create([
                'proveedor_id' => $this->proveedor_id,
                'sucursal_id' => $this->sucursal_id,
                'numero_factura' => $this->numero_factura,
                'total' => $this->total,
                'estado' => $this->estado,
                'observaciones' => $this->observaciones,
                'fecha_compra' => $this->fecha_compra,
            ]);

            foreach ($this->items as $item) {
                $compra->detalles()->create([
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        });

        session()->flash('message', 'Compra registrada con éxito.');
        return redirect()->route('compras.registrar');
    }

    public function render()
    {
        return view('livewire.compras.registrar-compra', [
            'proveedores' => Proveedor::where('estado', true)->get(),
            'sucursales' => Sucursal::where('estado', true)->get(),
            'productos' => Producto::where('estado', true)->get(),
        ]);
    }
}
