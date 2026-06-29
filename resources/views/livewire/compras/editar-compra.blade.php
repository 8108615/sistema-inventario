<div class="p-6 space-y-6">

    <!-- Edición de Cabecera -->
    <div class="bg-blue-900 border border-slate-700 rounded-t-lg p-4 text-white font-semibold">
        Editar Compra Nro. {{ $compra_id }}
    </div>

    <div class="bg-gray-800 p-6 rounded-b-lg border border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Proveedores (*)</label>
                <select wire:model="proveedor_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    <option value="">Seleccione un Proveedor</option>
                    @foreach($proveedores as $p)<option value="{{$p->id}}">{{$p->nombre}}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Tipo de Comprobante (*)</label>
                <select wire:model="tipo_comprobante" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    <option value="Factura">Factura</option>
                    <option value="Boleta">Boleta</option>
                </select>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Fecha (*)</label>
                    <input type="date" wire:model="fecha_compra" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                </div>
            </div>
        </div>
        
    </div>

    <!-- Paso 2 | Agregar Productos -->
    <div class="bg-slate-700 p-4 text-white font-semibold rounded-t-lg border border-slate-600">
        Agregar / Editar Productos
    </div>

    <div class="bg-gray-800 p-6 border-x border-b border-gray-700 text-white rounded-b-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Producto (*)</label>
                <select wire:model="producto_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    <option value="">Seleccione un Producto</option>
                    @foreach($productos as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->nombre_producto }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Cantidad (*)</label>
                <input type="number" wire:model="cantidad" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Precio Compra (*)</label>
                <input type="number" wire:model="precio_unitario" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
            </div>
        </div>

        <div class="flex justify-end">
            <button wire:click="agregarProducto" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold transition">
                Agregar Producto
            </button>
        </div>

        <!-- Tabla -->
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-gray-300 border border-gray-700">
                <thead class="bg-gray-900 text-gray-100 uppercase text-sm">
                    <tr>
                        <th class="p-3">Producto</th>
                        <th class="p-3 text-center">Cantidad</th>
                        <th class="p-3 text-right">Precio</th>
                        <th class="p-3 text-right">Total</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($detalles as $detalle)
                    <tr class="hover:bg-gray-750">
                        <td class="p-3">{{ $detalle->producto->nombre_producto ?? 'N/A' }}</td>
                        <td class="p-3 text-center">{{ $detalle->cantidad }}</td>
                        <td class="p-3 text-right">{{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="p-3 text-right font-bold">{{ number_format($detalle->subtotal, 2) }}</td>
                        <td class="p-3 text-center">
                            <button wire:click="eliminarDetalle({{$detalle->id}})" class="text-red-500 hover:text-red-400">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500 italic">No hay productos agregados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Finalizar -->
    <div class="bg-emerald-700 p-4 text-white font-semibold rounded-t-lg border border-emerald-600 mt-6">
        Finalizar Actualización
    </div>
    <div class="bg-gray-800 p-6 rounded-b-lg border-x border-b border-gray-700 text-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-300 mb-2">Sucursal (*)</label>
                <select wire:model="sucursal_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    <option value="">-- Seleccione una sucursal --</option>
                    @foreach($sucursales as $suc)
                        <option value="{{$suc->id}}">{{$suc->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-1 flex justify-end gap-2">
                <a href="{{ route('compras.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded font-bold transition text-sm">
                    Cancelar
                </a>
                <button wire:click="actualizarCompra" class="bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-6 rounded font-bold transition text-sm">
                    Editar Compra
                </button>
            </div>
        </div>
    </div>
</div>
