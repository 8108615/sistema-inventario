<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-white">VENTAS</h2>

        <button wire:click="verificarCajaYRedirigir"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Realizar Venta
        </button>

    </div>

    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
        <input type="text" wire:model.live="search" placeholder="Buscar por número de comprobante..."
               class="w-full bg-gray-900 border border-gray-700 text-white rounded p-2">
    </div>

    <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-x-auto">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-900 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">NRO</th>
                    <th class="px-4 py-3">COMPROBANTE</th>
                    <th class="px-4 py-3">FECHA</th>
                    <th class="px-4 py-3">CLIENTE</th>
                    <th class="px-4 py-3">USUARIO</th>
                    <th class="px-4 py-3">CAJA</th>
                    <th class="px-4 py-3">TIPO</th>
                    <th class="px-4 py-3">PAGO</th>
                    <th class="px-4 py-3">IMPUESTO</th>
                    <th class="px-4 py-3">TOTAL</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-sm">
                @foreach ($ventas as $venta)
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-4 py-3">{{ $venta->id }}</td>
                        <td class="px-4 py-3">{{ $venta->numero_comprobante }}</td>
                        <td class="px-4 py-3">{{ $venta->fecha_hora }}</td>
                        <td class="px-4 py-3">{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $venta->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $venta->caja->nombre ?? 'Caja '.$venta->caja_id }}</td>
                        <td class="px-4 py-3">{{ $venta->tipo_comprobante }}</td>
                        <td class="px-4 py-3">{{ $venta->metodo_pago }}</td>
                        <td class="px-4 py-3">{{ number_format($venta->impuesto, 2) }}</td>
                        <td class="px-4 py-3 font-bold text-blue-400">{{ number_format($venta->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ventas->links() }}
    </div>
</div>
