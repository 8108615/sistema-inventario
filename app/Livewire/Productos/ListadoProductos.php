<?php

namespace App\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ListadoProductos extends Component
{
    use WithPagination;

    public $search = '';

    // Escucha el evento que viene desde SweetAlert
    protected $listeners = ['eliminar-confirmado' => 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $productos = Producto::where('nombre_producto', 'like', '%' . $this->search . '%')
            ->orWhere('codigo_producto', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.productos.listado-productos', compact('productos'))
            ->layout('layouts.app');
    }

    // 1. Dispara el SweetAlert de confirmación
    public function confirmarEliminar($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            // Enviamos el ID y el NOMBRE para que el script de SweetAlert pueda mostrarlo
            $this->dispatch('confirmar-eliminacion', [
                'id' => $id,
                'nombre' => $producto->nombre_producto
            ]);
        }
    }


    public function delete($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->delete();

            // Guardamos el mensaje en la sesión
            session()->flash('alerta_exito', 'Producto eliminado correctamente');

            // Al recargar la página, app.blade.php detectará esta sesión
            return redirect()->route('productos.index');
        }
    }

    public function exportarExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportarCsv()
    {
        return Excel::download(new ProductosExport, 'productos.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportarPdf()
    {
        ini_set('memory_limit', '512M'); // Aumentar memoria para este proceso
        
        $productos = \App\Models\Producto::with('categoria')->get();

        $pdf = Pdf::loadView('pdf.productos', compact('productos'))
                ->setPaper('a4', 'landscape'); // <--- Esto pone la hoja en horizontal

        return response()->streamDownload(fn () => print($pdf->output()), 'reporte_productos.pdf');
    }
}
