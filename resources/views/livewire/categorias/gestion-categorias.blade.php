<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
                Categorías
            </h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de categorías registradas</p>
        </div>

        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar categoría..."
                   class="bg-gray-700 text-white rounded-lg px-4 py-2 border border-gray-600 w-64 focus:ring-2 focus:ring-blue-500">

            <button wire:click="$set('search', '')" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                Limpiar
            </button>

            <button wire:click="toggleModal" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center shadow-lg">
                <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Nueva Categoría
            </button>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700 border-b border-gray-600">
                <tr>
                    <th class="p-4 text-gray-400">#</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Descripción</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $index => $cat)
                <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                    <td class="p-4 text-gray-500 font-bold">{{ $categorias->firstItem() + $index }}</td>
                    <td class="p-4">{{ $cat->nombre }}</td>
                    <td class="p-4">{{ $cat->descripcion }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs {{ $cat->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                            {{ $cat->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </td>
                    <td class="p-4 flex justify-center space-x-2">
                        <button wire:click="editar({{ $cat->id }})" class="text-green-400 hover:text-green-200">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </button>
                        <button wire:click="confirmarEliminar({{ $cat->id }})" class="text-red-400 hover:text-red-200">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-900 border-t border-gray-700 flex justify-between items-center text-sm text-gray-400">
            <div>
                Mostrando {{ $categorias->firstItem() }} a {{ $categorias->lastItem() }} de {{ $categorias->total() }} registros
            </div>
            <div>
                {{ $categorias->links() }}
            </div>
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-gray-800 rounded-lg w-1/3 border border-gray-700 overflow-hidden">
                <div class="{{ $categoria_id ? 'bg-green-600' : 'bg-blue-600' }} p-4">
                    <h2 class="text-white text-xl font-bold">
                        {{ $categoria_id ? 'Editar Categoría' : 'Crear Categoría' }}
                    </h2>
                </div>

                <div class="p-6">
                    <label class="text-gray-300 block mb-1">Nombre (*)</label>
                    <input wire:model="nombre" wire:keydown.enter="guardar" type="text" placeholder="Nombre de la categoría"
                        class="w-full p-2 mb-3 bg-gray-700 text-white rounded border border-gray-600">
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <label class="text-gray-300 block mb-1">Descripción</label>
                    <textarea wire:model="descripcion" placeholder="Descripción"
                        class="w-full p-2 mb-3 bg-gray-700 text-white rounded border border-gray-600">
                    </textarea>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button wire:click="toggleModal" class="text-gray-400 hover:text-white px-4 py-2">Cancelar</button>
                        <button wire:click="guardar" class="{{ $categoria_id ? 'bg-green-600' : 'bg-blue-600' }} text-white px-4 py-2 rounded">
                            {{ $categoria_id ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
