<div class="p-6 bg-gray-900 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold border-l-4 border-blue-600 pl-3">Detalle del Producto: {{ $producto->nombre_producto }}</h2>
        <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg flex items-center">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Volver
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center">
            <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : asset('img/no-image.png') }}"
                 class="w-full h-64 object-cover rounded-lg mb-4 border border-gray-700">
            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $producto->estado ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                {{ $producto->estado ? 'PRODUCTO ACTIVO' : 'PRODUCTO INACTIVO' }}
            </span>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-400 text-sm">Categoría</p>
                <p class="font-semibold">{{ $producto->categoria->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Código Producto</p>
                <p class="font-semibold">{{ $producto->codigo_producto }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Código de Barras</p>
                <p class="font-semibold">{{ $producto->codigo_barra }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Unidad de Medida</p>
                <p class="font-semibold">{{ $producto->unidad }}</p> </div>
            <div class="md:col-span-2">
                <p class="text-gray-400 text-sm">Descripción</p>
                <p class="italic text-gray-200">{{ $producto->descripcion }}</p>
            </div>

            <hr class="md:col-span-2 border-gray-700 my-2">

            <div>
                <p class="text-gray-400 text-sm">Precio Compra</p>
                <p class="font-bold text-blue-400">${{ number_format($producto->precio_compra, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Precio Venta</p>
                <p class="font-bold text-green-400">${{ number_format($producto->precio_venta, 2) }}</p>
            </div>

            <div class="bg-gray-900 p-3 rounded">
                <p class="text-gray-400 text-sm">Stock Actual</p>
                <p class="text-xl font-bold">{{ $producto->stock_actual }}</p>
            </div>
            <div class="flex space-x-4">
                <div>
                    <p class="text-gray-400 text-sm">Min</p>
                    <p>{{ $producto->stock_minimo }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Max</p>
                    <p>{{ $producto->stock_maximo }}</p>
                </div>
            </div>

            <div class="md:col-span-2 pt-4 border-t border-gray-700 text-gray-500 text-xs">
                <p>Fecha de registro: {{ $producto->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
