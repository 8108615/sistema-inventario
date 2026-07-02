<div class="p-6 space-y-6">

    @if($paso >= 1)
        <div class="bg-blue-900 border border-slate-700 rounded-t-lg p-4 text-white font-semibold">
            Paso 1 | {{ $paso > 1 ? 'Compra Creada (Nro. ' . $compra_id . ')' : 'Llene los Datos del Formulario' }}
        </div>

        @if($paso == 1)
            <div class="bg-gray-800 p-6 rounded-b-lg border border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <!-- Columna 1: Proveedor -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Proveedores (*)</label>
                        <div class="flex">
                            <span class="bg-gray-900 border border-gray-600 px-3 flex items-center text-gray-400 rounded-l-md"><i class="fas fa-users"></i></span>
                            <select wire:model="proveedor_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded-r-md">
                                <option value="">Seleccione un Proveedor</option>
                                @foreach($proveedores as $p)<option value="{{$p->id}}">{{$p->nombre}}</option>@endforeach
                            </select>
                            @error('proveedor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Columna 2: Tipo de Comprobante (CORREGIDO: Ahora está en su propio bloque) -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2">Tipo de Comprobante (*)</label>
                        <select wire:model="tipo_comprobante" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                        </select>
                    </div>

                    <!-- Columna 3: Fecha y Observaciones (Puedes ajustarlo según prefieras) -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2">Fecha (*)</label>
                            <input type="date" wire:model="fecha_compra" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                        </div>

                    </div>
                </div>
                <div class="flex gap-2">
                    <button wire:click="cancelarCompra" class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-2 rounded font-bold">
                        Cancelar
                    </button>
                    <button wire:click="crearCabecera" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold">Crear Compra y Añadir Productos</button>
                </div>
            </div>
        @else
            <div class="bg-gray-800 p-4 border-b border-x border-gray-700 rounded-b-lg text-gray-300 text-sm">
                <div class="grid grid-cols-3 gap-4">
                    <div><strong>Proveedor:</strong> {{ $proveedores->find($proveedor_id)->nombre ?? 'N/A' }}</div>
                    <div><strong>Fecha:</strong> {{ $fecha_compra }}</div>
                    <div><strong>Estado:</strong> <span class="text-green-400 font-bold">Pendiente</span></div>
                </div>
            </div>
        @endif
    @endif

    @if($paso >= 2)
        <div class="bg-slate-700 p-4 text-white font-semibold rounded-t-lg border border-slate-600">
            Paso 2 | Agregar Productos
        </div>

        <div class="bg-gray-800 p-6 border-x border-b border-gray-700 text-white rounded-b-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Producto (*)</label>
                    <select wire:model="producto_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                        <option value="">Seleccione un Producto</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nombre_producto }}</option> <!-- Cambia 'nombre' si tu campo se llama diferente -->
                        @endforeach
                    </select>
                    @error('producto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Cantidad (*)</label>
                    <input type="number" wire:model="cantidad" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    @error('cantidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Precio Compra (*)</label>
                    <input type="number" wire:model="precio_unitario" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                    @error('precio_unitario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">

                <!-- Botones a la izquierda -->
                <div class="flex gap-2">
                    <button wire:click="cancelarCompra" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-bold transition">
                        Cancelar
                    </button>
                    <button wire:click="volverAlPasoUno" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded font-bold transition">
                        Volver
                    </button>
                </div>

                <!-- Botón a la derecha -->
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
                            <td class="p-3">{{ $detalle->producto->nombre_producto }}</td>
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
                            <td colspan="4" class="p-4 text-center text-gray-500 italic">No hay productos agregados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Total acumulado -->
                <div class="flex justify-end mt-4">
                    <div class="bg-gray-900 p-4 rounded border border-gray-600">
                        <span class="text-gray-400 font-bold">Total de la Compra: </span>
                        <span class="text-white text-xl font-bold ml-4">
                            {{ number_format($detalles->sum('subtotal'), 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($paso >= 2 && count($detalles) > 0)
        <div class="bg-emerald-700 p-4 text-white font-semibold rounded-t-lg border border-emerald-600 mt-6">
            Paso 3 | Finalizar Compra
        </div>
        <div class="bg-gray-800 p-6 rounded-b-lg border-x border-b border-gray-700 text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <!-- Selector de Sucursal -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-300 mb-2">Seleccione Sucursal de Destino (*)</label>
                    <select wire:model="sucursal_id" class="w-full bg-gray-900 border border-gray-600 text-white p-2 rounded">
                        <option value="">-- Seleccione una sucursal --</option>
                        @foreach($sucursales as $suc)
                            <option value="{{$suc->id}}">{{$suc->nombre}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón Finalizar -->
                <div class="md:col-span-2 flex justify-end gap-2">
                    <button wire:click="cancelarCompra" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded font-bold transition text-sm">
                        Cancelar
                    </button>
                    <button wire:click="finalizarCompra" class="bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-6 rounded font-bold transition text-sm">
                        Finalizar Compra
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
