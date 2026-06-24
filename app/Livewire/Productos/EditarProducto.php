<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarProducto extends Component
{
    use WithFileUploads;

    public $producto, $categoria_id, $codigo_producto, $codigo_barra, $nombre_producto;
    public $descripcion, $precio_compra, $precio_venta, $stock_actual, $stock_minimo, $stock_maximo;
    public $unidad_medida, $estado, $imagen, $nueva_imagen;

    public function mount(Producto $producto)
    {
        $this->producto = $producto;
        $this->categoria_id = $producto->categoria_id;
        $this->codigo_producto = $producto->codigo_producto;
        $this->codigo_barra = $producto->codigo_barra;
        $this->nombre_producto = $producto->nombre_producto;
        $this->descripcion = $producto->descripcion;
        $this->precio_compra = $producto->precio_compra;
        $this->precio_venta = $producto->precio_venta;
        $this->stock_actual = $producto->stock_actual;
        $this->stock_minimo = $producto->stock_minimo;
        $this->stock_maximo = $producto->stock_maximo;
        $this->unidad_medida = $producto->unidad_medida;
        $this->estado = $producto->estado;
        $this->imagen = $producto->imagen;
    }

    public function update()
    {
        $data = $this->validate([
            'categoria_id' => 'required',
            'nombre_producto' => 'required',
        ]);

        if ($this->nueva_imagen) {
            $data['imagen'] = $this->nueva_imagen->store('productos', 'public');
        }

        $this->producto->update($data);
        return redirect()->route('productos.index');
    }

    public function render()
    {
        return view('livewire.productos.editar-producto', [
            'categorias' => Categoria::all()
        ])->layout('layouts.app');
    }
}
