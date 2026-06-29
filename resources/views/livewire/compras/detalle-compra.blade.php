<div class="p-6 text-gray-300">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white uppercase">Detalle de Compra Nro. {{ $compra->id }}</h1>
        <div class="flex gap-2">
            <!-- Botón Imprimir -->
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <x-heroicon-o-printer class="w-5 h-5" /> Imprimir / PDF
            </button>
            <a href="{{ route('compras.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Volver</a>
        </div>
    </div>

    <div id="printable-area" class="bg-gray-800 p-6 rounded-lg border border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm">
            <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
            <p><strong>Sucursal:</strong> {{ $compra->sucursal->nombre }}</p>
            <p><strong>Fecha:</strong> {{ $compra->created_at->format('d/m/Y') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($compra->estado) }}</p>
        </div>

        <table class="w-full text-left">
            <thead class="bg-gray-900 uppercase text-xs text-gray-500">
                <tr>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3 text-center">Cantidad</th>
                    <th class="px-4 py-3 text-right">Precio</th>
                    <th class="px-4 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($compra->detalles as $detalle)
                <tr>
                    <td class="px-4 py-3">{{ $detalle->producto->nombre_producto }}</td>
                    <td class="px-4 py-3 text-center">{{ $detalle->cantidad }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 text-right text-xl font-bold">
            Total: {{ number_format($compra->total, 2) }}
        </div>
    </div>
    <!-- Estilos para impresión -->
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; color: black !important; }
            #printable-area { border: none !important; background-color: white !important; }
            table { border: 1px solid #000; }
            th, td { border: 1px solid #ccc; padding: 8px; }
        }
    </style>
</div>


