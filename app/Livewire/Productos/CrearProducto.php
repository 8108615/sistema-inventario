<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearProducto extends Component
{
    use WithFileUploads;

    public $categoria_id, $codigo_producto, $codigo_barra, $nombre_producto, $descripcion;
    public $precio_compra, $precio_venta, $stock_actual, $stock_minimo, $stock_maximo;
    public $unidad_medida = 'unidad', $estado = true, $imagen;

    public function store()
    {
        $this->validate([
            'categoria_id' => 'required',
            'codigo_producto' => 'required',
            'nombre_producto' => 'required',
            'imagen' => 'required|image|max:1024',
        ]);

        $path = $this->imagen->store('productos', 'public');

        Producto::create([
            'categoria_id'    => $this->categoria_id,
            'codigo_producto' => $this->codigo_producto,
            'codigo_barra'    => $this->codigo_barra,
            'nombre_producto' => $this->nombre_producto,
            'descripcion'     => $this->descripcion,
            'imagen'          => $path,
            'precio_compra'   => $this->precio_compra,
            'precio_venta'    => $this->precio_venta,
            'stock_actual'    => $this->stock_actual,
            'stock_minimo'    => $this->stock_minimo,
            'stock_maximo'    => $this->stock_maximo,
            'unidad_medida'   => $this->unidad_medida,
            'estado'          => $this->estado,
        ]);

        return redirect()->route('productos.index');
    }

    public function render()
    {
        return view('livewire.productos.crear-producto', [
            'categorias' => Categoria::all()
        ])->layout('layouts.app');
    }
}
