<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">Gestión de Caja</h1>
            <p class="text-gray-400 text-sm mt-1 pl-4">Listado de Cajas Aperturadas y cerradas</p>
        </div>
        <button onclick="document.getElementById('modalApertura').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" /> Aperturar Caja
        </button>
    </div>

    <!-- Buscador -->
    <div class="bg-gray-800 p-4 rounded-t-lg border-b border-gray-700 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <input wire:model.live="search"
                type="text"
                placeholder="Buscar por usuario..."
                class="bg-gray-700 text-white border-none rounded px-3 py-1 text-sm w-64">

            <button wire:click="$set('search', '')"
                    class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded text-sm">
                Limpiar
            </button>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
        <table class="w-full text-left text-gray-300 text-sm">
            <thead class="bg-gray-900 text-gray-100 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nro</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Apertura</th>
                    <th class="px-4 py-3">Cierre</th>
                    <th class="px-4 py-3">Saldo. Inicial</th>
                    <th class="px-4 py-3">Saldo. Final</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($cajas as $index => $caja)
                <tr class="border-b border-gray-700 hover:bg-gray-750">
                    <td class="px-4 py-3">{{ $cajas->firstItem() + $index }}</td>
                    <td class="px-4 py-3">{{ $caja->user->name }}</td>
                    <td class="px-4 py-3">{{ $caja->fecha_hora_apertura }}</td>
                    <td class="px-4 py-3">{{ $caja->fecha_hora_cierre ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $simboloMoneda }}{{ number_format($caja->saldo_inicial, 2) }}</td>
                    <td class="px-4 py-3">{{ $caja->saldo_final ? $simboloMoneda . number_format($caja->saldo_final, 2) : '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs {{ $caja->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                            {{ $caja->estado ? 'Aperturada' : 'Cerrada' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex justify-center space-x-1">
                        <a href="{{ route('cajas.detalles', $caja->id) }}" class="bg-blue-600 p-2 rounded text-white">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($caja->estado)
                            <button onclick="confirmarCierre({{ $caja->id }})" class="bg-red-600 p-2 rounded text-white">
                                <i class="fas fa-lock"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 flex justify-between items-center text-sm text-gray-400">
        <div>Mostrando {{ $cajas->firstItem() }} a {{ $cajas->lastItem() }} de {{ $cajas->total() }} registros</div>
        <div>{{ $cajas->links() }}</div>
    </div>

    <div id="modalApertura" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-gray-800 p-6 rounded-lg w-96 text-white border border-gray-600">
            <h2 class="text-xl mb-4 font-bold">Monto de Apertura</h2>
            <input type="number" wire:model="saldo_inicial" class="w-full p-2 bg-gray-700 rounded mb-4 text-white border-none">
            <div class="flex justify-end gap-2">
                <button onclick="document.getElementById('modalApertura').classList.add('hidden')" class="bg-gray-600 px-4 py-2 rounded">Cancelar</button>
                <button wire:click="abrirCaja" onclick="document.getElementById('modalApertura').classList.add('hidden')" class="bg-blue-600 px-4 py-2 rounded font-bold">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmarCierre(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir el cierre de caja!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cerrar caja'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('confirmar-cierre', { id: id });
            }
        })
    }
</script>
