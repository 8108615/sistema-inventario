<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">Proveedores</h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de proveedores registrados</p>
        </div>
        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar..." class="bg-gray-700 text-white rounded-lg px-4 py-2 border border-gray-600 w-64">
            <button wire:click="$set('search', '')" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Limpiar</button>
            @can('proveedores.crear')
                <button wire:click="create" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center shadow-lg">
                    <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Nuevo Proveedor
                </button>
            @endcan
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full text-left text-sm text-gray-400">
            <thead class="bg-gray-900 text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Empresa</th>
                    <th class="px-4 py-3">Teléfono</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Dirección</th>
                    <th class="px-4 py-3">Notas</th>
                    <th class="px-4 py-3 text-center">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($proveedores as $index => $p)
                <tr class="hover:bg-gray-750 transition">
                    <td class="px-4 py-4 text-white">{{ $proveedores->firstItem() + $index }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->nombre }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->empresa }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->telefono }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->email }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->direccion }}</td>
                    <td class="px-4 py-4 text-white font-medium">{{ $p->notas }}</td>
                    <td class="px-4 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $p->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                            {{ $p->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-center flex justify-center space-x-2">
                        @can('proveedores.editar')
                            <button wire:click="edit({{ $p->id }})" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                <x-heroicon-o-pencil class="w-4 h-4" />
                            </button>
                        @endcan
                        @can('proveedores.eliminar')
                            <button wire:click="confirmarEliminar({{ $p->id }})" class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                <x-heroicon-o-trash class="w-4 h-5" />
                            </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 bg-gray-900 border-t border-gray-700">
            {{ $proveedores->links() }}
        </div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
            <div class="bg-gray-900 border border-gray-700 rounded-xl w-full max-w-2xl shadow-2xl overflow-hidden">
                <div class="p-4 {{ $proveedor_id ? 'bg-green-700' : 'bg-blue-600' }} flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">{{ $proveedor_id ? 'Editar proveedor' : 'Crear proveedor' }}</h2>
                    <button wire:click="$set('isOpen', false)" class="text-white hover:text-gray-200">✕</button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Nombre (*)</label>
                            <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                                <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">👤</span>
                                <input wire:model="nombre" placeholder="Nombre del proveedor" class="w-full bg-gray-800 text-white p-2.5 outline-none">
                            </div>
                            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Teléfono (*)</label>
                            <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                                <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">📞</span>
                                <input wire:model="telefono" placeholder="Telefono de contacto" class="w-full bg-gray-800 text-white p-2.5 outline-none">
                            </div>
                            @error('telefono') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Email(*)</label>
                            <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                                <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">✉️</span>
                                <input wire:model="email" placeholder="correo@dominio.com" class="w-full bg-gray-800 text-white p-2.5 outline-none">
                            </div>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Empresa(*)</label>
                            <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                                <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">🏢</span>
                                <input wire:model="empresa" placeholder="Empresa asociada" class="w-full bg-gray-800 text-white p-2.5 outline-none">
                            </div>
                            @error('empresa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Dirección(*)</label>
                        <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                            <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">📍</span>
                            <textarea wire:model="direccion" placeholder="Direccion del proveedor" class="w-full bg-gray-800 text-white p-2.5 outline-none h-20"></textarea>
                        </div>
                        @error('direccion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Notas</label>
                        <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                            <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">📝</span>
                            <textarea wire:model="notas" placeholder="Notas adicionales" class="w-full bg-gray-800 text-white p-2.5 outline-none h-20"></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Estado</label>
                        <div class="flex bg-gray-800 border border-gray-700 rounded-lg overflow-hidden focus-within:ring-1 focus-within:ring-blue-500">
                            <span class="p-3 text-gray-500 bg-gray-800 border-r border-gray-700">⚙️</span>
                            <select wire:model="estado" class="w-full bg-gray-800 text-white p-2.5 outline-none">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 p-6 pt-0">
                    <button wire:click="$set('isOpen', false)" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">Cancelar</button>
                    <button wire:click="store" class="px-5 py-2.5 {{ $proveedor_id ? 'bg-green-600 hover:bg-green-700' : 'bg-blue-600 hover:bg-blue-500' }} text-white rounded-lg transition">
                        {{ $proveedor_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
