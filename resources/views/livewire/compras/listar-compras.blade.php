<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase">Compras</h1>
            <p class="text-gray-400">Listado de compras registradas</p>
        </div>

        <a href="{{ route('compras.registrar') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2">
            <x-heroicon-o-plus-circle class="w-5 h-5" /> Crear Nuevo
        </a>
    </div>

    <div class="flex gap-2 mb-4">
        <input type="text" wire:model.live="search" placeholder="Buscar compra..." class="w-full md:w-1/3 bg-gray-900 border border-gray-600 text-white p-2 rounded">
        <button wire:click="$set('search', '')" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</button>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-900 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-4 py-3">Nro</th>
                    <th class="px-4 py-3">Proveedor</th>
                    <th class="px-4 py-3">Sucursal</th>
                    <th class="px-4 py-3">Productos</th>
                    <th class="px-4 py-3">Tipo de Comprobante</th>
                    <th class="px-4 py-3">Total Cancelado</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($compras as $compra)
                <tr>
                    <td class="px-4 py-3">{{ $compra->id }}</td>
                    <td class="px-4 py-3">{{ $compra->proveedor->nombre }}</td>
                    <td class="px-4 py-3">{{ $compra->sucursal->nombre }}</td>
                    <td class="px-4 py-3 text-sm">
                        @foreach($compra->detalles as $detalle)
                            <div class="text-gray-300">• {{ $detalle->producto->nombre_producto }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">{{ $compra->tipo_comprobante }}</td>
                    <td class="px-4 py-3">{{ $simboloMoneda }}{{ number_format($compra->total, 2) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded {{ $compra->estado == 'recibida' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">
                            {{ ucfirst($compra->estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">

                        <a href="{{ route('compras.detalle', $compra->id) }}" class="bg-blue-600 p-2 rounded text-white hover:bg-blue-700">
                            <x-heroicon-o-eye class="w-4 h-4"/>
                        </a>
                        <a href="{{ route('compras.editar', $compra->id) }}" class="bg-green-600 p-2 rounded text-white">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <button
                            wire:click="confirmarEliminacion({{ $compra->id }}, 'la Compra Nro. {{ $compra->id }}')"
                            class="bg-red-600 p-2 rounded text-white hover:bg-red-700">
                            <x-heroicon-o-trash class="w-4 h-4"/>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $compras->links() }}
        </div>
    </div>
</div>
