<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white uppercase tracking-wider border-l-4 border-blue-600 pl-3">
            Dashboard
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">

        <!-- Cambiamos a grid-cols-4 o 5 para que quepan más elementos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

            <!-- Tarjeta: Total Productos -->
            <div class="bg-gray-800 p-3 rounded-md border border-gray-700 shadow flex items-center gap-3">
                <div class="text-blue-400">
                    <x-heroicon-o-cube class="w-8 h-8" />
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Productos</p>
                    <h3 class="text-sm font-bold text-white">{{ $totalProductos }}</h3>
                </div>
            </div>

            <!-- Tarjeta: Stock Crítico -->
            <div class="bg-gray-800 p-3 rounded-md border border-gray-700 shadow flex items-center gap-3">
                <div class="{{ $stockCritico > 0 ? 'text-red-500' : 'text-green-500' }}">
                    <x-heroicon-o-exclamation-triangle class="w-8 h-8" />
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Stock Crítico</p>
                    <h3 class="text-sm font-bold {{ $stockCritico > 0 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $stockCritico }}
                    </h3>
                </div>
            </div>

            <!-- Tarjeta: Lotes por vencer -->
            <div class="bg-gray-800 p-3 rounded-md border border-gray-700 shadow flex items-center gap-3">
                <div class="{{ $lotesPorVencer > 0 ? 'text-yellow-500' : 'text-green-500' }}">
                    <x-heroicon-o-calendar class="w-8 h-8" />
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Lotes a Vencer</p>
                    <h3 class="text-sm font-bold {{ $lotesPorVencer > 0 ? 'text-yellow-500' : 'text-green-500' }}">
                        {{ $lotesPorVencer }}
                    </h3>
                </div>
            </div>

            <!-- Tarjeta: Inversión Total -->
            <div class="bg-gray-800 p-3 rounded-md border border-gray-700 shadow flex items-center gap-3">
                <div class="text-green-500">
                    <x-heroicon-o-banknotes class="w-8 h-8" />
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Inversión</p>
                    <h3 class="text-sm font-bold text-white">{{ number_format($inversionTotal, 2) }}</h3>
                </div>
            </div>

        </div>
    </div>

    <!-- Sección de Tablas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Tabla: Productos en Stock Crítico -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 shadow">
            <div class="p-4 border-b border-gray-700 flex justify-between items-center">
                <h3 class="font-bold text-gray-200">Productos en Stock Crítico</h3>
                <span class="text-xs bg-red-900 text-red-200 px-2 py-1 rounded">Atención necesaria</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-900 uppercase text-xs text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3 text-center">Actual</th>
                            <th class="px-4 py-3 text-center">Mínimo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($productosCriticos as $prod)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-4 py-3">
                                <a href="{{ route('productos.editar', $prod->id) }}" class="hover:text-blue-400 underline">
                                    {{ $prod->nombre_producto }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-red-500">{{ $prod->stock_actual }}</td>
                            <td class="px-4 py-3 text-center">{{ $prod->stock_minimo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabla: Últimos Lotes Ingresados -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 shadow">
            <div class="p-4 border-b border-gray-700">
                <h3 class="font-bold text-gray-200">Últimos Lotes Ingresados</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-900 uppercase text-xs text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Lote</th>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3 text-right">Cant.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($ultimosLotes as $lote)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-4 py-3">{{ $lote->codigo_lote }}</td>
                            <td class="px-4 py-3">{{ $lote->producto->nombre_producto }}</td>
                            <td class="px-4 py-3 text-right font-bold">{{ $lote->cantidad_inicial }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
