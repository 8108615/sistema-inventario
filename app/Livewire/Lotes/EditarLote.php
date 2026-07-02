<?php

namespace App\Livewire\Lotes;

use Livewire\Component;
use App\Models\Lote;
use App\Models\Producto;
use App\Models\Proveedor;

class EditarLote extends Component
{
    public $lote;
    public $producto_id, $proveedor_id, $codigo_lote, $cantidad_inicial, $precio_compra, $precio_venta, $fecha_entrada, $fecha_vencimiento;

    protected $rules = [
        'producto_id'      => 'required',
        'proveedor_id'     => 'required',
        'codigo_lote'      => 'required|max:50',
        'cantidad_inicial' => 'required|numeric|min:1',
        'fecha_entrada'    => 'required|date',
    ];

    public function mount(Lote $lote)
    {
        $this->lote = $lote;
        $this->producto_id = $lote->producto_id;
        $this->proveedor_id = $lote->proveedor_id;
        $this->codigo_lote = $lote->codigo_lote;
        $this->cantidad_inicial = $lote->cantidad_inicial;
        $this->precio_compra = $lote->precio_compra;
        $this->precio_venta = $lote->precio_venta;
        $this->fecha_entrada = $lote->fecha_entrada;
        $this->fecha_vencimiento = $lote->fecha_vencimiento;
    }

    public function actualizar()
    {
        $this->validate();

        $this->lote->update([
            'producto_id'       => $this->producto_id,
            'proveedor_id'      => $this->proveedor_id,
            'codigo_lote'       => $this->codigo_lote,
            'cantidad_inicial'  => $this->cantidad_inicial,
            'precio_compra'     => $this->precio_compra,
            'precio_venta'      => $this->precio_venta,
            'fecha_entrada'     => $this->fecha_entrada,
            'fecha_vencimiento' => $this->fecha_vencimiento,
        ]);

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Lote actualizado correctamente'
        ]);

        return redirect()->route('lotes.index');
    }

    public function render()
    {
        return view('livewire.lotes.editar-lote', [
            'productos' => Producto::all(),
            'proveedores' => Proveedor::all()
        ]);
    }
}
