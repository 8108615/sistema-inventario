<div class="p-6 bg-gray-900 text-white">
    <h2 class="bg-blue-800 p-3 mb-6 font-bold uppercase rounded">Creación de Producto</h2>

    <div class="grid grid-cols-4 gap-6">
        <div class="col-span-3 grid grid-cols-3 gap-4">
            <div class="col-span-1">
                <label>Categoría (*)</label>
                <select wire:model="categoria_id" class="w-full bg-gray-700 p-2 rounded">
                    <option value="">Seleccione una Categoría</option>
                    @foreach($categorias as $cat) <option value="{{ $cat->id }}">{{ $cat->nombre }}</option> @endforeach
                </select>
            </div>
            <div class="col-span-1">
                <label>Codigo (*)</label>
                <input wire:model.live="codigo_producto" class="w-full bg-gray-700 p-2 rounded" placeholder="Ingrese el Codigo...">
            </div>
            <div class="col-span-1">
                <label>Nombre (*)</label>
                <input wire:model="nombre_producto" class="w-full bg-gray-700 p-2 rounded" placeholder="Ingrese el Nombre...">
            </div>

            <div class="col-span-3">
                <label>Descripcion (*)</label>
                <textarea wire:model="descripcion" class="w-full h-32 bg-gray-700 p-2 rounded"></textarea>
            </div>

            <input type="number" wire:model="precio_compra" class="bg-gray-700 p-2 rounded" placeholder="Precio Compra">
            <input type="number" wire:model="precio_venta" class="bg-gray-700 p-2 rounded" placeholder="Precio Venta">
            <input type="text" wire:model="unidad_medida" class="bg-gray-700 p-2 rounded" placeholder="Unidad de Medida">
        </div>

        <div class="col-span-1 flex flex-col">
            <label>Imagen del Producto (*)</label>
            <div class="w-full h-48 border-2 border-dashed border-gray-600 rounded flex items-center justify-center mb-2 overflow-hidden bg-gray-800">
                @if($imagen) <img src="{{ $imagen->temporaryUrl() }}" class="h-full w-full object-cover"> @else <span class="text-gray-500">Vista previa</span> @endif
            </div>
            <input type="file" wire:model="imagen" class="w-full text-sm mb-4">

            <label>Codigo de Barra</label>
            <div class="bg-gray-700 p-4 text-center rounded border border-gray-600">
                <p class="text-2xl font-mono tracking-widest">{{ $codigo_producto ?: '--------' }}</p>
                <small class="text-gray-400">Generado automático</small>
            </div>
        </div>
    </div>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-gray-600 rounded">Cancelar</a>
        <button wire:click="store" class="px-4 py-2 bg-blue-600 rounded">Guardar</button>
    </div>
</div>
