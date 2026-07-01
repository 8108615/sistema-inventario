<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
                Productos
            </h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de productos registrados</p>
        </div>
        <a href="{{ route('productos.crear') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
            Crear Nuevo
        </a>
    </div>

    <div class="bg-gray-800 p-4 rounded-t-lg border-b border-gray-700 flex justify-between items-center">
        <div class="flex space-x-2">
            <button wire:click="exportarExcel" class="bg-green-700 hover:bg-green-600 text-white px-3 py-1 rounded text-sm flex items-center">
                <x-heroicon-o-table-cells class="w-4 h-4 mr-1" /> Excel
            </button>
            <button wire:click="exportarCsv" class="bg-yellow-700 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm flex items-center">
                <x-heroicon-o-document-text class="w-4 h-4 mr-1" /> CSV
            </button>
            <button wire:click="exportarPdf" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded text-sm flex items-center">
                <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1" /> PDF
            </button>
            <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm flex items-center">
                <x-heroicon-o-printer class="w-4 h-4 mr-1" /> Imprimir
            </button>
        </div>
        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar producto..." class="bg-gray-700 text-white border-none rounded px-3 py-1 text-sm">
            <button wire:click="$set('search', '')" class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm">Limpiar</button>
        </div>
    </div>

    <div class="bg-gray-800 overflow-hidden shadow-md">
        <table class="min-w-full text-left text-sm text-gray-400">
            <thead class="bg-gray-900 text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nro</th>
                    <th class="px-4 py-3">Categoría</th>
                    <th class="px-4 py-3">Código</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Imagen</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Unidad</th>
                    <th class="px-4 py-3">Precio Venta</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($productos as $index => $p)
                <tr class="hover:bg-gray-750">
                    <td class="px-4 py-3">{{ $productos->firstItem() + $index }}</td>
                    <td class="px-4 py-3">{{ $p->categoria->nombre ?? 'N/A' }}</td>
                    <td class="px-4 py-3">{{ $p->codigo_producto }}</td>
                    <td class="px-4 py-3">{{ $p->nombre_producto }}</td>
                    <td class="px-4 py-3">
                        <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : asset('img/no-image.png') }}" class="w-8 h-8 rounded">
                    </td>
                    <td class="px-4 py-3">{{ $p->stock_actual }}</td>
                    <td class="px-4 py-3">{{ $p->unidad }}</td>
                    <td class="px-4 py-3">{{ $simboloMoneda }} {{ number_format($p->precio_venta, 2) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs {{ $p->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                            {{ $p->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex justify-center space-x-1">
                        <a href="{{ route('productos.ver', $p->id) }}" class="bg-blue-500 hover:bg-blue-400 text-white p-2 rounded">
                            <x-heroicon-o-eye class="w-5 h-5"/>
                        </a>
                        <a href="{{ route('productos.editar', $p->id) }}" class="bg-green-600 hover:bg-green-500 text-white p-2 rounded">
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                        </a>
                        <button wire:click="confirmarEliminar({{ $p->id }})" class="bg-red-600 hover:bg-red-500 text-white p-2 rounded">
                            <x-heroicon-o-trash class="w-4 h-4"/>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-between items-center text-sm text-gray-400">
        <div>
            Mostrando {{ $productos->firstItem() }} a {{ $productos->lastItem() }} de {{ $productos->total() }} registros
        </div>
        <div>
            {{ $productos->links() }}
        </div>
    </div>
</div>
