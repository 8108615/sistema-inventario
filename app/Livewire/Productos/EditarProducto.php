<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class EditarProducto extends Component
{
    use WithFileUploads;

    public $producto, $categoria_id, $codigo_producto, $codigo_barra, $nombre_producto;
    public $descripcion, $precio_compra, $precio_venta, $stock_actual, $stock_minimo, $stock_maximo;
    public $unidad_medida, $estado, $imagen, $nueva_imagen;

    protected $rules = [
        'categoria_id'    => 'required',
        'codigo_producto' => 'required|max:50',
        'nombre_producto' => 'required|min:3|max:255',
        'descripcion'     => 'nullable|max:500',
        'precio_compra'   => 'required|numeric|min:0',
        'precio_venta'    => 'required|numeric|min:0',
        'stock_actual'    => 'required|numeric|min:0',
        'nueva_imagen'    => 'nullable|image|max:1024', // Opcional al editar
    ];

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
        // Validamos usando las reglas de arriba
        $this->validate();

        $datos = [
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
        ];

        // Solo procesamos la imagen si el usuario subió una nueva
        if ($this->nueva_imagen) {
            // Borrar la anterior si existe
            if ($this->imagen) {
                Storage::disk('public')->delete($this->imagen);
            }
            $datos['imagen'] = $this->nueva_imagen->store('productos', 'public');
        }

        $this->producto->update($datos);

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Producto actualizado correctamente'
        ]);

        return redirect()->route('productos.index');
    }

    public function render()
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = null;
        if ($this->codigo_barra) {
            $barcodeImage = base64_encode($generator->getBarcode($this->codigo_barra, $generator::TYPE_CODE_128));
        }

        return view('livewire.productos.editar-producto', [
            'categorias' => Categoria::all(),
            'barcodeImage' => $barcodeImage
        ])->layout('layouts.app');
    }
}
