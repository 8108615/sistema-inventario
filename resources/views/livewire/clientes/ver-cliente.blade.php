<div>
    @if($modalVisible && $cliente)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg w-1/2 border border-gray-600 shadow-xl text-white">
                <h2 class="text-xl font-bold mb-4 border-b border-gray-600 pb-2">Detalle del Cliente</h2>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>Nombre:</strong> {{ $cliente->nombre_cliente }}</p>
                    <p><strong>Tipo:</strong> {{ $cliente->tipo_persona }}</p>
                    @if($cliente->razon_social) <p><strong>Razón Social:</strong> {{ $cliente->razon_social }}</p> @endif
                    <p><strong>Documento:</strong> {{ $cliente->tipo_documento }} - {{ $cliente->numero_documento }}</p>
                    <p><strong>NIT:</strong> {{ $cliente->nit ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                    <p><strong>Email:</strong> {{ $cliente->email }}</p>
                    <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
                    <p><strong>Estado:</strong> {{ $cliente->estado ? 'Activo' : 'Inactivo' }}</p>
                </div>
                <button wire:click="cerrar" class="mt-6 bg-gray-600 hover:bg-gray-500 px-4 py-2 rounded">Cerrar</button>
            </div>
        </div>
    @endif
</div>
