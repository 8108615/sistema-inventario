<div class="p-6 bg-gray-900 text-white">
    <h2 class="bg-green-700 p-4 mb-6 font-bold uppercase rounded shadow-lg text-lg">Editar Producto</h2>

    @if ($errors->any())
        <div class="bg-red-600 p-4 rounded mb-6 text-white font-bold">
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
        </div>
    @endif

    <div class="grid grid-cols-4 gap-8">
        <div class="col-span-3 space-y-6">
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Categoría (*)</label>
                    <select wire:model="categoria_id" class="w-full bg-gray-800 p-2 rounded border border-gray-700">
                        @foreach($categorias as $cat) <option value="{{ $cat->id }}">{{ $cat->nombre }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Código (*)</label>
                    <input wire:model="codigo_producto" class="w-full bg-gray-800 p-2 rounded border border-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre (*)</label>
                    <input wire:model="nombre_producto" class="w-full bg-gray-800 p-2 rounded border border-gray-700">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
                <textarea wire:model="descripcion" class="w-full h-24 bg-gray-800 border border-gray-700 p-2 rounded"></textarea>
            </div>

            <div class="grid grid-cols-6 gap-4">
                <input type="number" wire:model="precio_compra" placeholder="P. Compra" class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                <input type="number" wire:model="precio_venta" placeholder="P. Venta" class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                <input type="number" wire:model="stock_minimo" placeholder="Stock Min." class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                <input type="number" wire:model="stock_maximo" placeholder="Stock Max." class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                <input type="number" wire:model="stock_actual" placeholder="Stock Act." class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                <select wire:model="unidad_medida" class="bg-gray-800 border border-gray-700 p-2 rounded text-sm">
                    <option value="UNIDAD">UNIDAD</option><option value="LITROS">LITROS</option><option value="CAJAS">CAJAS</option>
                </select>
            </div>
        </div>

        <div class="col-span-1 space-y-4">
            <div class="w-full h-40 bg-gray-800 border border-gray-700 rounded flex items-center justify-center overflow-hidden">
                @if($nueva_imagen) <img src="{{ $nueva_imagen->temporaryUrl() }}" class="h-full w-full object-cover">
                @else <img src="{{ asset('storage/' . $imagen) }}" class="h-full w-full object-cover"> @endif
            </div>
            <input type="file" wire:model="nueva_imagen" class="text-xs w-full">

            <label class="block text-sm font-medium text-gray-300 mt-4">Código de Barra</label>
            <input wire:model.live="codigo_barra" class="w-full bg-gray-800 border border-gray-700 p-2 text-center rounded">

            <div class="bg-white p-2 rounded flex flex-col items-center">
                @if($barcodeImage)
                    <img src="data:image/png;base64,{{ $barcodeImage }}" class="max-w-full">
                    <p class="text-black font-bold">{{ $codigo_barra }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-4 border-t border-gray-700 pt-6">
        <a href="{{ route('productos.index') }}" class="px-6 py-2 bg-gray-700 rounded">Cancelar</a>
        <button wire:click="update" class="px-6 py-2 bg-green-600 rounded font-bold">Actualizar</button>
    </div>
</div>
