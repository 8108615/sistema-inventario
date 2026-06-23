<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">Roles</h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Gestión de roles del sistema</p>
        </div>
        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar rol..." class="bg-gray-700 text-white rounded-lg px-4 py-2 border border-gray-600">
            <button wire:click="toggleModal" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
                <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Nuevo Rol
            </button>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700 border-b border-gray-600">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $index => $role)
                <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                    <td class="p-4 text-gray-500 font-bold">{{ $roles->firstItem() + $index }}</td>
                    <td class="p-4">{{ $role->name }}</td>
                    <td class="p-4 flex justify-center space-x-2">

                        <button wire:click="editar({{ $role->id }})" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </button>

                        <button wire:click="abrirPermisos({{ $role->id }})" class="p-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg flex items-center">
                            <x-heroicon-o-shield-check class="w-5 h-5 mr-1" /> Permisos
                        </button>
                        <button wire:click="confirmarEliminar({{ $role->id }})" class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-gray-900 border-t border-gray-700">{{ $roles->links() }}</div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-gray-800 rounded-lg w-1/3 border border-gray-700 overflow-hidden">
                <div class="{{ $role_id ? 'bg-green-600' : 'bg-blue-600' }} p-4">
                    <h2 class="text-white text-xl font-bold">{{ $role_id ? 'Editar Rol' : 'Crear Rol' }}</h2>
                </div>
                <div class="p-6">
                    <label class="text-gray-300 block mb-1">Nombre del rol (*)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">👤</span>
                        <input wire:model="name" type="text" wire:keydown.enter="guardar" placeholder="Nombre del rol" class="w-full pl-10 p-2.5 bg-gray-700 text-white rounded-lg border border-gray-600">
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button wire:click="toggleModal" class="text-gray-400 px-4 py-2">Cancelar</button>
                        <button wire:click="guardar" class="{{ $role_id ? 'bg-green-600' : 'bg-blue-600' }} text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($isPermissionModalOpen)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-gray-800 rounded-lg w-full max-w-6xl border border-gray-700 shadow-2xl overflow-hidden">
                <div class="bg-gray-700 p-6 border-b border-gray-600">
                    <h2 class="text-white text-2xl font-bold">Permisos del Rol: {{ $name }}</h2>
                    <p class="text-gray-400 mt-1">Gestión de permisos para el rol seleccionado.</p>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        // Definimos los módulos excluyendo 'Archivos'
                        $modulos = ['Dashboard','Roles', 'Usuarios', 'Categorias', 'Sucursales'];
                    @endphp
                    
                    @foreach($modulos as $modulo)
                        <div class="bg-gray-900/50 p-4 rounded-lg border border-gray-700 shadow-inner">
                            <h3 class="font-bold text-blue-400 mb-3 border-b border-gray-700 pb-2 uppercase tracking-wide text-sm">
                                {{ $modulo }}
                            </h3>
                            <div class="space-y-2">
                                @foreach(\Spatie\Permission\Models\Permission::where('name', 'like', strtolower($modulo).'%')->get() as $permiso)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="checkbox" wire:model="permisosAsignados" value="{{ $permiso->name }}" 
                                            class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-300 group-hover:text-white transition capitalize">
                                            {{ str_replace('.', ' ', $permiso->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 bg-gray-700 border-t border-gray-600 flex justify-end space-x-3">
                    <button wire:click="$set('isPermissionModalOpen', false)" class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg transition">
                        Cancelar
                    </button>
                    <button wire:click="guardarPermisos" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg flex items-center shadow-lg transition">
                        <x-heroicon-o-check-circle class="w-5 h-5 mr-2" /> Guardar permisos
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>