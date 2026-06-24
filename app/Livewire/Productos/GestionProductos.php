<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // Importante para la imagen

class GestionProductos extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $isOpen = false;
    public $producto_id;

    // Campos del producto
    public $categoria_id, $codigo_producto, $codigo_barra, $nombre_producto,
           $descripcion, $imagen, $precio_compra, $precio_venta,
           $stock_actual, $stock_minimo, $stock_maximo, $unidad_medida = 'unidad', $estado = true;

    protected $rules = [
        'categoria_id' => 'required',
        'codigo_producto' => 'required|max:50',
        'codigo_barra' => 'required|max:50',
        'nombre_producto' => 'required|max:100',
        'descripcion' => 'required',
        'precio_compra' => 'required|numeric',
        'precio_venta' => 'required|numeric',
        'stock_actual' => 'required|integer',
        'stock_minimo' => 'required|integer',
        'stock_maximo' => 'required|integer',
        'unidad_medida' => 'required',
        'estado' => 'required',
        'imagen' => 'nullable|image|max:1024',
    ];

    public function render()
    {
        $productos = Producto::where('nombre_producto', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categorias = Categoria::all(); // Para llenar el select

        return view('livewire.productos.gestion-productos', compact('productos', 'categorias'))
            ->layout('layouts.app');
    }

    public function create()
    {
        $this->reset(['producto_id', 'categoria_id', 'codigo_producto', 'codigo_barra', 'nombre_producto',
                      'descripcion', 'imagen', 'precio_compra', 'precio_venta', 'stock_actual',
                      'stock_minimo', 'stock_maximo', 'unidad_medida', 'estado']);
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        Producto::updateOrCreate(['id' => $this->producto_id], [
            'categoria_id'    => $this->categoria_id,
            'codigo_producto' => $this->codigo_producto,
            'codigo_barra'    => $this->codigo_barra,
            'nombre_producto' => $this->nombre_producto,
            'descripcion'     => $this->descripcion,
            'precio_compra'   => $this->precio_compra,
            'precio_venta'    => $this->precio_venta,
            'stock_actual'    => $this->stock_actual,
            'stock_minimo'    => $this->stock_minimo,
            'stock_maximo'    => $this->stock_maximo,
            'unidad_medida'   => $this->unidad_medida,
            'estado'          => $this->estado,
        ]);

        $this->isOpen = false;
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Producto guardado']);
    }
}
