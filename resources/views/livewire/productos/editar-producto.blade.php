<div class="p-6 bg-gray-900 text-white">
    <h2 class="bg-green-700 p-3 mb-6 font-bold uppercase rounded">Editar Producto</h2>

    <div class="grid grid-cols-4 gap-6">
        <div class="col-span-3 grid grid-cols-3 gap-4">
            <select wire:model="categoria_id" class="bg-gray-700 p-2 rounded">
                @foreach($categorias as $cat) <option value="{{ $cat->id }}">{{ $cat->nombre }}</option> @endforeach
            </select>
            <input wire:model="codigo_producto" class="bg-gray-700 p-2 rounded">
            <input wire:model="nombre_producto" class="bg-gray-700 p-2 rounded">
            </div>

        <div class="col-span-1 flex flex-col items-center">
            <div class="w-full h-48 border border-gray-600 rounded flex items-center justify-center mb-2 overflow-hidden">
                @if($nueva_imagen)
                    <img src="{{ $nueva_imagen->temporaryUrl() }}" class="h-full w-full object-cover">
                @else
                    <img src="{{ asset('storage/' . $imagen) }}" class="h-full w-full object-cover">
                @endif
            </div>
            <input type="file" wire:model="nueva_imagen" class="w-full text-xs">
        </div>
    </div>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-gray-600 rounded">Cancelar</a>
        <button wire:click="update" class="px-4 py-2 bg-green-600 rounded">Actualizar</button>
    </div>
</div>
