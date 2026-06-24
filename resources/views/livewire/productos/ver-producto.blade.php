<div class="p-6 bg-gray-900 text-white">
    <h2 class="text-2xl font-bold mb-6">Detalle de: {{ $producto->nombre_producto }}</h2>
    <div class="bg-gray-800 p-6 rounded-lg grid grid-cols-2 gap-4">
        <div>
            <p><strong>Código:</strong> {{ $producto->codigo_producto }}</p>
            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
            <p><strong>Precio Venta:</strong> ${{ $producto->precio_venta }}</p>
            <p><strong>Stock Actual:</strong> {{ $producto->stock_actual }}</p>
        </div>
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-40 rounded">
        </div>
    </div>
    <a href="{{ route('productos.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-600 rounded">Volver</a>
</div>
