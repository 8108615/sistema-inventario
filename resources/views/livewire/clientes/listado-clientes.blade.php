<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
                Clientes
            </h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de clientes registrados</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
            Crear Nuevo
        </a>
    </div>

    <div class="bg-gray-800 p-4 rounded-t-lg border-b border-gray-700 flex justify-between items-center">

        <div class="flex items-center space-x-2">
            <input wire:model.live="search" type="text" placeholder="Buscar..."
            class="bg-gray-700 text-white border-none rounded px-3 py-1 text-sm">
            <button wire:click="$set('search', '')" class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm">Limpiar</button>
        </div>
    </div>


    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-x-auto">
        <table class="w-full text-left text-gray-300 text-sm">
            <thead class="bg-gray-900 text-gray-100 uppercase text-xs">
                <tr>
                    <th class="p-3">Nro</th>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Tipo Persona</th>
                    <th class="p-3">Razón Social</th>
                    <th class="p-3">NIT</th>
                    <th class="p-3">Dirección</th>
                    <th class="p-3">Teléfono</th>
                    <th class="p-3">Correo</th>
                    <th class="p-3">Tipo Doc.</th>
                    <th class="p-3">Nro Doc.</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($clientes as $index => $cli)
                <tr class="hover:bg-gray-750">
                    <td class="p-3">{{ $clientes->firstItem() + $index }}</td>
                    <td class="p-3 font-medium">{{ $cli->nombre_cliente }}</td>
                    <td class="p-3">{{ $cli->tipo_persona }}</td>
                    <td class="p-3">{{ $cli->razon_social ?? '-' }}</td>
                    <td class="p-3">{{ $cli->nit ?? '-' }}</td>
                    <td class="p-3">{{ $cli->direccion ?? '-' }}</td>
                    <td class="p-3">{{ $cli->telefono ?? '-' }}</td>
                    <td class="p-3">{{ $cli->email ?? '-' }}</td>
                    <td class="p-3">{{ $cli->tipo_documento }}</td>
                    <td class="p-3">{{ $cli->numero_documento }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs {{ $cli->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                            {{ $cli->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-2">
                            <button wire:click="$dispatch('verCliente', { id: {{ $cli->id }} })" class="bg-blue-500 text-white p-2 rounded">
                                <i class="fas fa-eye"></i>
                            </button>

                            <a href="{{ route('clientes.edit', $cli->id) }}" class="bg-green-500 text-white p-2 rounded"><i class="fas fa-edit"></i></a>

                            <button
                                wire:click="confirmarEliminacion({{ $cli->id }}, '{{ $cli->nombre_cliente }}')"
                                class="bg-red-500 text-white p-2 rounded">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-gray-900 text-gray-400 text-sm">
            Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} registros
            <div class="mt-2">{{ $clientes->links() }}</div>
        </div>
    </div>

    @livewire('clientes.ver-cliente')
</div>
