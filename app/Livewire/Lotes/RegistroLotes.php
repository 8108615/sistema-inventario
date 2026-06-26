<?php

namespace App\Livewire\Lotes;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;

class RegistroLotes extends Component
{
    // Declara las variables públicas que coinciden con el wire:model
    public $producto_id, $proveedor_id, $codigo_lote, $cantidad_inicial;
    public $precio_compra, $precio_venta, $fecha_entrada, $fecha_vencimiento;

    public function render()
    {
        return view('livewire.lotes.registro-lotes', [
            'productos' => Producto::all(),
            'proveedores' => Proveedor::where('estado', true)->get()
        ]);
    }


    public function guardar()
    {
        $this->validate([
            'producto_id' => 'required',
            'proveedor_id' => 'required',
            'codigo_lote' => 'required',
            'cantidad_inicial' => 'required|numeric|min:1',
            'fecha_entrada'    => 'required|date',
        ]);

        DB::transaction(function () {
            Lote::create([
                'producto_id' => $this->producto_id,
                'proveedor_id' => $this->proveedor_id,
                'codigo_lote' => $this->codigo_lote,
                'fecha_entrada' => $this->fecha_entrada ?? date('Y-m-d'),
                'fecha_vencimiento' => $this->fecha_vencimiento,
                'cantidad_inicial' => $this->cantidad_inicial,
                'cantidad_actual' => $this->cantidad_inicial,
                'precio_compra' => $this->precio_compra,
                'precio_venta' => $this->precio_venta,
                'estado' => true,
            ]);

            \App\Models\Producto::find($this->producto_id)->increment('stock_actual', $this->cantidad_inicial);
        });

        // 1. Guardamos el mensaje en la sesión para que aparezca después de la redirección
        session()->flash('alerta_exito', 'Lote registrado y stock actualizado');

        // 2. Redirigimos al listado
        return redirect()->route('lotes.index');
    }
}
