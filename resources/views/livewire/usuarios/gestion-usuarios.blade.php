<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">Usuarios</h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Gestión de usuarios y accesos del sistema</p>
        </div>
        <button wire:click="$set('isModalOpen', true)" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center shadow-lg transition">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Nuevo Usuario
        </button>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700 border-b border-gray-600">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Imagen</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 text-center">Rol</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $index => $user)
                <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                    <td class="p-4">{{ $usuarios->firstItem() + $index }}</td>
                    <td class="p-4">
                        <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('img/default-user.png') }}" 
                             class="w-10 h-10 rounded-full object-cover border border-gray-600">
                    </td>
                    <td class="p-4">{{ $user->name }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 bg-blue-900/50 text-blue-300 rounded-full text-xs font-bold border border-blue-800">
                            {{ $user->getRoleNames()->first() ?? 'Sin rol' }}
                        </span>
                    </td>
                    <td class="p-4 flex justify-center space-x-2">
                        <button wire:click="editar({{ $user->id }})" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-gray-900 border-t border-gray-700">{{ $usuarios->links() }}</div>
    </div>

    @if($isModalOpen)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg w-full max-w-lg border border-gray-700 shadow-2xl overflow-hidden">
            <div class="bg-blue-600 p-4">
                <h2 class="text-white text-lg font-bold">{{ $user_id ? 'Editar Usuario' : 'Crear Usuario' }}</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex justify-center">
                    <div class="w-24 h-24 bg-gray-700 rounded-full overflow-hidden border-2 border-gray-600 relative">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($user_id && \App\Models\User::find($user_id)->image)
                            <img src="{{ asset('storage/'.\App\Models\User::find($user_id)->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-xs">Sin foto</div>
                        @endif
                    </div>
                </div>

                <input type="file" wire:model="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-gray-700 file:text-white hover:file:bg-gray-600 cursor-pointer">

                <input wire:model="name" type="text" placeholder="Nombre completo (*)" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600">
                <input wire:model="email" type="email" placeholder="Correo electrónico (*)" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600">
                
                <select wire:model="role" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600">
                    <option value="">Seleccione un rol (*)</option>
                    @foreach(\Spatie\Permission\Models\Role::all() as $r)
                        <option value="{{ $r->name }}">{{ $r->name }}</option>
                    @endforeach
                </select>

                <div class="grid grid-cols-2 gap-4">
                    <input wire:model="password" type="password" placeholder="Contraseña" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600">
                    <input wire:model="password_confirmation" type="password" placeholder="Confirmar" class="w-full p-3 bg-gray-700 text-white rounded-lg border border-gray-600">
                </div>
            </div>

            <div class="p-6 bg-gray-900 border-t border-gray-700 flex justify-end space-x-3">
                <button wire:click="$set('isModalOpen', false)" class="px-4 py-2 text-gray-400 hover:text-white transition">Cancelar</button>
                <button wire:click="guardar" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition shadow-lg">Guardar</button>
            </div>
        </div>
    </div>
    @endif
</div>