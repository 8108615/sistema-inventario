<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
                LOTES
            </h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de lotes de productos registrados</p>
        </div>

        <div class="flex items-center space-x-2">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar lote, producto o proveedor..."
                class="bg-gray-900 border border-gray-700 text-white rounded p-2 focus:ring-blue-500 focus:border-blue-500 w-64">

            <a href="{{ route('lotes.registrar') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
                <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
                Crear Nuevo
            </a>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg overflow-hidden shadow">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700 text-white uppercase text-sm">
                <tr>
                    <th class="px-6 py-3">NRO</th>
                    <th class="px-6 py-3">PRODUCTO</th>
                    <th class="px-6 py-3">PROVEEDOR</th>
                    <th class="px-6 py-3">CÓD. LOTE</th>
                    <th class="px-6 py-3">F. ENTRADA</th>
                    <th class="px-6 py-3">F. VENC.</th>
                    <th class="px-6 py-3">CANT. ACTUAL</th>
                    <th class="px-6 py-3">P. COMPRA</th>
                    <th class="px-6 py-3">P. VENTA</th>
                    <th class="px-6 py-3">ESTADO</th>
                    <th class="px-6 py-3 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($lotes as $index => $lote)
                <tr class="hover:bg-gray-700/50 transition">
                    <td class="px-6 py-4">{{ $lotes->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $lote->producto->nombre_producto ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $lote->proveedor->nombre_empresa ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-mono">{{ $lote->codigo_lote }}</td>
                    <td class="px-6 py-4">{{ date('d/m/Y', strtotime($lote->fecha_entrada)) }}</td>
                    <td class="px-6 py-4">{{ $lote->fecha_vencimiento ? date('d/m/Y', strtotime($lote->fecha_vencimiento)) : '-' }}</td>
                    <td class="px-6 py-4 font-bold text-blue-400">{{ $lote->producto->stock_actual ?? 0 }}</td>
                    <td class="px-6 py-4">{{ $simboloMoneda }}{{ number_format($lote->precio_compra, 2) }}</td>
                    <td class="px-6 py-4">{{ $simboloMoneda }}{{ number_format($lote->precio_venta, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $lote->estado ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $lote->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex justify-center space-x-2">
                        <button wire:click="verDetalle({{ $lote->id }})" class="bg-blue-500 hover:bg-blue-400 text-white p-2 rounded">
                            <x-heroicon-o-eye class="w-5 h-5" />
                        </button>
                        <a href="{{ route('lotes.editar', $lote->id) }}" class="bg-green-600 hover:bg-green-500 text-white p-2 rounded">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </a>
                        <button
                            wire:click="confirmarEliminacion({{ $lote->id }})"
                            class="bg-red-600 hover:bg-red-500 text-white p-2 rounded">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-900 border-t border-gray-700">
            <div class="text-gray-400 text-sm mb-2">
                Mostrando {{ $lotes->firstItem() }} a {{ $lotes->lastItem() }} de {{ $lotes->total() }} resultados
            </div>
            {{ $lotes->links() }}
        </div>
    </div>
    @if($isVerOpen && $loteSeleccionado)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
            <div class="bg-gray-800 rounded-lg w-full max-w-2xl p-6 text-white border border-gray-700">
                <div class="flex justify-between items-center mb-4 border-b border-gray-700 pb-2">
                    <h2 class="text-xl font-bold text-blue-400">Detalle del Lote: {{ $loteSeleccionado->codigo_lote }}</h2>
                    <button wire:click="$set('isVerOpen', false)" class="bg-gray-600 hover:bg-gray-500 text-white p-2 rounded">✕</button>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <p><strong>Producto:</strong> {{ $loteSeleccionado->producto->nombre_producto ?? 'N/A' }}</p>
                        <p><strong>Proveedor:</strong> {{ $loteSeleccionado->proveedor->nombre ?? 'N/A' }}</p>
                        <p><strong>Estado:</strong>
                            <span class="{{ $loteSeleccionado->estado ? 'text-green-400' : 'text-red-400' }}">
                                {{ $loteSeleccionado->estado ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p><strong>F. Entrada:</strong> {{ date('d/m/Y', strtotime($loteSeleccionado->fecha_entrada)) }}</p>
                        <p><strong>F. Vencimiento:</strong>
                            {{ $loteSeleccionado->fecha_vencimiento ? date('d/m/Y', strtotime($loteSeleccionado->fecha_vencimiento)) : 'Sin fecha de vencimiento' }}
                        </p>
                    </div>

                    <div class="col-span-2 grid grid-cols-2 gap-4 bg-gray-900 p-4 rounded border border-gray-700">
                        <p><strong>Cant. Inicial (Ingresada):</strong> {{ $loteSeleccionado->cantidad_inicial }}</p>
                        <p><strong>Cant. Actual (Lote):</strong> {{ $loteSeleccionado->cantidad_actual }}</p>
                        <p><strong>Stock Total (Producto):</strong> {{ $loteSeleccionado->producto->stock_actual ?? 0 }}</p>
                        <p><strong>Precio Compra:</strong> {{ $simboloMoneda }}{{ number_format($loteSeleccionado->precio_compra, 2) }}</p>
                        <p><strong>Precio Venta:</strong> {{ $simboloMoneda }}{{ number_format($loteSeleccionado->precio_venta, 2) }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="$set('isVerOpen', false)" class="bg-gray-600 hover:bg-gray-500 px-6 py-2 rounded transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>


