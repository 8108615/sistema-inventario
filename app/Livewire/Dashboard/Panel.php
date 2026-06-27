<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Lote;
use Livewire\Attributes\Layout;

class Panel extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        // 1. Stock Crítico: Productos donde stock_actual <= stock_minimo
        $stockCritico = Producto::where('estado', true)
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->count();

        // 2. Lotes próximos a vencer: Lotes que vencen en los próximos 30 días
        $fechaLimite = now()->addDays(30);
        $lotesPorVencer = Lote::where('estado', true)
            ->whereNotNull('fecha_vencimiento')
            ->where('fecha_vencimiento', '<=', $fechaLimite)
            ->count();

        // 3. Total Productos (activos)
        $totalProductos = Producto::where('estado', true)->count();

        // 4. Inversión Total (Suma de precio_compra * cantidad_actual de todos los lotes activos)
        $inversionTotal = Lote::where('estado', true)
            ->sum(\DB::raw('precio_compra * cantidad_actual'));

        $productosCriticos = Producto::where('estado', true)
            ->whereColumn('stock_actual', '<=', 'stock_minimo')
            ->limit(5)
            ->get();

        // Nueva consulta: Últimos lotes (con la relación del producto)
        $ultimosLotes = Lote::with('producto')
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard.panel', [
            'stockCritico' => $stockCritico,
            'lotesPorVencer' => $lotesPorVencer,
            'totalProductos' => $totalProductos,
            'inversionTotal' => $inversionTotal,
            'productosCriticos' => $productosCriticos, // Nueva variable
            'ultimosLotes' => $ultimosLotes,           // Nueva variable
        ]);
    }
}
