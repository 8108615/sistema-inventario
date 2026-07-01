<div class="space-y-6">
    <!-- Encabezado con título y subtítulo -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white border-l-4 border-blue-600 pl-3">VENTAS</h2>
            <p class="text-gray-400 text-sm mt-1 ml-1">Listado de ventas realizadas</p>
        </div>

        <button wire:click="verificarCajaYRedirigir"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Realizar Venta
        </button>
    </div>

    <!-- Buscador con botón Limpiar -->
    <div class="bg-gray-900 p-4 rounded-t-lg border border-gray-700 flex items-center gap-2">
        <input type="text"
            wire:model.live="search"
            placeholder="Buscar por número de comprobante..."
            class="bg-gray-800 border border-gray-700 text-white rounded px-3 py-1.5 text-sm w-64 focus:outline-none focus:border-blue-500">

        <button wire:click="limpiar"
                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-1.5 rounded text-sm transition">
            Limpiar
        </button>
    </div>

    <!-- Tabla de datos -->
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
                    <th class="px-4 py-3 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-sm">
                @foreach ($ventas as $venta)
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-4 py-3">{{ $venta->id }}</td>
                        <td class="px-4 py-3">{{ $venta->numero_comprobante }}</td>
                        <td class="px-4 py-3">{{ $venta->fecha_hora }}</td>
                        <td class="px-4 py-3">{{ $venta->cliente->nombre_cliente ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $venta->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $venta->caja->nombre ?? 'Caja '.$venta->caja_id }}</td>
                        <td class="px-4 py-3">{{ $venta->tipo_comprobante }}</td>
                        <td class="px-4 py-3">{{ $venta->metodo_pago }}</td>
                        <td class="px-4 py-3">{{ $simboloMoneda }}{{ number_format($venta->impuesto, 2) }}</td>
                        <td class="px-4 py-3 font-bold text-blue-400">{{ $simboloMoneda }}{{ number_format($venta->total, 2) }}</td>
                        <td class="px-4 py-3 flex justify-center space-x-1">
                            <button wire:click="verDetalle({{ $venta->id }})"
                                class="bg-blue-500 hover:bg-blue-400 text-white p-2 rounded">
                                <x-heroicon-o-eye class="w-5 h-5"/>
                            </button>
                            <a href="{{ route('ventas.editar', $venta->id) }}"
                                class="bg-green-600 hover:bg-green-500 text-white p-2 rounded">
                                    <x-heroicon-o-pencil class="w-4 h-4"/>
                                </a>
                            <button
                                wire:click="confirmarEliminacion({{ $venta->id }}, '{{ $venta->numero_comprobante }}')"
                                class="bg-red-600 p-2 rounded text-white hover:bg-red-700">
                                <x-heroicon-o-trash class="w-4 h-4"/>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Contador de registros -->
        <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
            Mostrando {{ $ventas->firstItem() ?? 0 }} a {{ $ventas->lastItem() ?? 0 }} de {{ $ventas->total() }} registros
        </div>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $ventas->links() }}
    </div>

    <!-- Modal de Detalles -->
    @if($verDetalleModal && $ventaSeleccionada)
        <div class="fixed inset-0 bg-gray-900/75 flex items-center justify-center z-50">
            <div class="bg-gray-800 rounded-lg shadow-xl w-3/4 max-h-[80vh] overflow-y-auto border border-gray-700">
                <div class="p-4 border-b border-gray-700 flex justify-between items-center bg-gray-900">
                    <h3 class="text-white font-bold">Detalles de Venta: {{ $ventaSeleccionada->numero_comprobante }}</h3>
                    <button wire:click="cerrarModal" class="text-gray-400 hover:text-white">✕</button>
                </div>

                <div class="p-6 text-gray-300">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <p><strong>Cliente:</strong> {{ $ventaSeleccionada->cliente->nombre_cliente ?? 'N/A' }}</p>
                        <p><strong>Fecha:</strong> {{ $ventaSeleccionada->fecha_hora }}</p>
                        <p><strong>Total:</strong> {{ $simboloMoneda }}{{ number_format($ventaSeleccionada->total, 2) }}</p>
                    </div>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-700 text-gray-400 text-xs uppercase">
                                <th class="py-2">Producto</th>
                                <th class="py-2">Cantidad</th>
                                <th class="py-2">Precio</th>
                                <th class="py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventaSeleccionada->detalles as $detalle)
                                <tr class="border-b border-gray-700">
                                    <td class="py-2">{{ $detalle->producto->nombre_producto ?? 'N/A' }}</td>
                                    <td class="py-2">{{ $detalle->cantidad }}</td>
                                    <td class="py-2">{{ $simboloMoneda }}{{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="py-2">{{ $simboloMoneda }}{{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
