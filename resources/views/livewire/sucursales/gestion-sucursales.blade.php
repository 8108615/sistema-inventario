<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
                Sucursales
            </h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de sucursales registradas</p>
        </div>

        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar Sucursal..."
                   class="bg-gray-700 text-white rounded-lg px-4 py-2 border border-gray-600 w-64 focus:ring-2 focus:ring-blue-500">
            <button wire:click="$set('search', '')" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Limpiar</button>
            @can('sucursales.crear')
                <button wire:click="create" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center shadow-lg">
                    <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Nueva Sucursal
                </button>
            @endcan
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full text-left text-sm text-gray-400">
            <thead class="bg-gray-900 text-white uppercase">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Dirección</th>
                    <th class="px-6 py-3">Teléfono</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($sucursales as $index => $sucursal)
                <tr>
                    <td class="px-6 py-4 text-white">
                        {{ $sucursales->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 text-white">{{ $sucursal->nombre }}</td>
                    <td class="px-6 py-4">{{ $sucursal->direccion }}</td>
                    <td class="px-6 py-4">{{ $sucursal->telefono }}</td>
                    <td class="px-6 py-4 text-center flex justify-center space-x-2">
                        @can('sucursales.editar')
                            <button wire:click="edit({{ $sucursal->id }})" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </button>
                        @endcan
                        @can('sucursales.eliminar')
                            <button wire:click="confirmarEliminar({{ $sucursal->id }})"
                                class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-900 border-t border-gray-700 flex justify-between items-center text-sm text-gray-400">
            <div>
                Mostrando {{ $sucursales->firstItem() }} a {{ $sucursales->lastItem() }} de {{ $sucursales->total() }} registros
            </div>
            <div>
                {{ $sucursales->links() }}
            </div>
        </div>
    </div>

    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
        <div class="bg-gray-900 border border-gray-700 rounded-xl w-full max-w-md shadow-2xl overflow-hidden">
            <div class="p-4 {{ $sucursal_id ? 'bg-green-700' : 'bg-blue-600' }} flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">{{ $sucursal_id ? 'Editar sucursal' : 'Crear sucursal' }}</h2>
                <button wire:click="$set('isOpen', false)" class="text-white hover:text-gray-200">✕</button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nombre (*)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">🏢</span>
                        <input wire:model="nombre" type="text" wire:keydown.enter="store"
                            class="w-full bg-gray-800 border {{ $errors->has('nombre') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-lg pl-10 p-2.5 focus:ring-blue-500 outline-none">
                    </div>
                    <x-error-message for="nombre" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Dirección (*)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">📍</span>
                        <textarea wire:model="direccion"
                                class="w-full bg-gray-800 border {{ $errors->has('direccion') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-lg pl-10 p-2.5 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <x-error-message for="direccion" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Teléfono</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">📞</span>
                        <input wire:model="telefono" wire:keydown.enter="store" type="text"
                            class="w-full bg-gray-800 border {{ $errors->has('telefono') ? 'border-red-500' : 'border-gray-700' }} text-white rounded-lg pl-10 p-2.5 focus:ring-blue-500 outline-none">
                    </div>
                    <x-error-message for="telefono" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Estado (*)</label>
                    <select wire:model="estado" wire:keydown.enter="store" class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg p-2.5">
                        <option value="1">Activa</option>
                        <option value="0">Inactiva</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 p-6 pt-0">
                <button wire:click="$set('isOpen', false)" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">Cancelar</button>
                <button wire:click="store" class="px-5 py-2.5 {{ $sucursal_id ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-500' }} text-white rounded-lg transition">
                    {{ $sucursal_id ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
