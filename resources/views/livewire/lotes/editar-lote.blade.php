<div class="p-6">
    <div class="bg-green-600 text-white p-4 rounded-t-lg mb-4">
        <h2 class="text-xl font-bold">EDITAR LOTE: {{ $codigo_lote }}</h2>
    </div>

    <div class="bg-gray-800 p-6 rounded-b-lg shadow-md text-gray-200">

        @if (session()->has('message'))
            <div class="bg-green-600 text-white p-3 mb-4 rounded">{{ session('message') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium mb-1">Producto (*)</label>
                <select wire:model="producto_id" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                    <option value="">Seleccione...</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre_producto }}</option>
                    @endforeach
                </select>
                @error('producto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Proveedor (*)</label>
                <select wire:model="proveedor_id" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                    <option value="">Seleccione...</option>
                    @foreach($proveedores as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nombre . ' - ' . $prov->empresa }}</option>
                    @endforeach
                </select>
                @error('proveedor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Código Lote (*)</label>
                <input type="text" wire:model="codigo_lote" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                @error('codigo_lote') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Cantidad a Ingresar (*)</label>
                <input type="number" wire:model="cantidad_inicial" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                @error('cantidad_inicial') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Precio Compra</label>
                <input type="number" step="0.01" wire:model="precio_compra" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                @error('precio_compra') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Precio Venta</label>
                <input type="number" step="0.01" wire:model="precio_venta" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                @error('precio_venta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Fecha Entrada</label>
                <input type="date" wire:model="fecha_entrada" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
                @error('fecha_entrada') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Fecha Vencimiento</label>
                <input type="date" wire:model="fecha_vencimiento" class="w-full bg-gray-900 border border-gray-700 p-2 rounded text-white">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('lotes.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
            <button wire:click="actualizar" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                Actualizar
            </button>
        </div>
    </div>
</div>
