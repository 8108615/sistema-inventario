<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white uppercase tracking-wider">Registrar Compra</h1>
        <button wire:click="guardarCompra" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold">
            Guardar Compra
        </button>
    </div>

    <!-- Encabezado con los campos de la BD -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-800 p-4 rounded-lg border border-gray-700 mb-6">
        <select wire:model="proveedor_id" class="bg-gray-900 border-gray-700 text-white rounded-md">
            <option value="">Seleccionar Proveedor</option>
            @foreach($proveedores as $prov)<option value="{{ $prov->id }}">{{ $prov->nombre }}</option>@endforeach
        </select>

        <select wire:model="sucursal_id" class="bg-gray-900 border-gray-700 text-white rounded-md">
            <option value="">Seleccionar Sucursal</option>
            @foreach($sucursales as $suc)<option value="{{ $suc->id }}">{{ $suc->nombre }}</option>@endforeach
        </select>

        <input type="text" wire:model="numero_factura" placeholder="Nº Factura" class="bg-gray-900 border-gray-700 text-white rounded-md">

        <select wire:model="estado" class="bg-gray-900 border-gray-700 text-white rounded-md">
            <option value="recibida">Recibida</option>
            <option value="pendiente">Pendiente</option>
        </select>

        <input type="date" wire:model="fecha_compra" class="bg-gray-900 border-gray-700 text-white rounded-md">

        <input type="text" wire:model="observaciones" placeholder="Observaciones (opcional)" class="bg-gray-900 border-gray-700 text-white rounded-md col-span-3">
    </div>

    <!-- ... (El resto de la tabla de productos sigue igual) ... -->
    <div class="mt-4 text-right text-xl font-bold text-white">
        Total: {{ number_format($total, 2) }}
    </div>
</div>
