<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Traemos todos los productos
        return Producto::with('categoria')->get();
    }

    public function headings(): array
    {
        return [
            "ID",
            "Categoría",
            "Código Producto",
            "Código Barra",
            "Nombre",
            "Precio Compra",
            "Precio Venta",
            "Stock Actual",
            "Stock Mínimo",
            "Stock Máximo",
            "Unidad",
            "Estado",
            "Fecha Creación"
        ];
    }

    // Mapeamos los datos para que coincidan con los encabezados
    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->categoria->nombre ?? 'N/A',
            $producto->codigo_producto,
            $producto->codigo_barra,
            $producto->nombre_producto,
            $producto->precio_compra,
            $producto->precio_venta,
            $producto->stock_actual,
            $producto->stock_minimo,
            $producto->stock_maximo,
            $producto->unidad_medida, // O $producto->unidad si usaste el accesor
            $producto->estado ? 'Activo' : 'Inactivo',
            $producto->created_at->format('d/m/Y H:i'),
        ];
    }
}
