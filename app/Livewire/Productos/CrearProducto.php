<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithFileUploads;
use Picqer\Barcode\BarcodeGeneratorPNG;

class CrearProducto extends Component
{
    use WithFileUploads;

    public $categoria_id, $codigo_producto, $codigo_barra, $nombre_producto, $descripcion;
    public $precio_compra = 0, $precio_venta = 0, $stock_actual = 0, $stock_minimo = 0, $stock_maximo = 0;
    public $unidad_medida = 'UNIDAD', $estado = true, $imagen;

    protected $rules = [
        'categoria_id'    => 'required',
        'codigo_producto' => 'required|max:50',
        'nombre_producto' => 'required|min:3|max:255',
        'descripcion'     => 'nullable|max:500',
        'precio_compra'   => 'required|numeric|min:0',
        'precio_venta'    => 'required|numeric|min:0',
        'stock_minimo'    => 'required|numeric|min:0',
        'stock_maximo'    => 'required|numeric|min:0',
        'stock_actual'    => 'required|numeric|min:0',
        'imagen'          => 'required|image|max:1024',
    ];

    public function store()
    {
        // Al dejarlo vacío, Livewire usa automáticamente la propiedad $rules de arriba
        $this->validate();

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

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Producto guardado correctamente'
        ]);

        return redirect()->route('productos.index');
    }

    public function render()
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = null;

        if ($this->codigo_barra) {
            // Genera el código en formato EAN13 o CODE128
            // Para EAN13 el código debe tener 12 o 13 dígitos
            $barcodeImage = base64_encode($generator->getBarcode($this->codigo_barra, $generator::TYPE_CODE_128));
        }

        return view('livewire.productos.crear-producto', [
            'barcodeImage' => $barcodeImage,
            'categorias' => Categoria::all()
        ]);
    }
}
