<div class="p-6 text-white">
    <nav class="text-sm mb-4">
        <a href="{{ route('cajas.index') }}" class="text-blue-400 hover:underline">Cajas</a>
        <span class="text-gray-500"> / Movimientos de caja</span>
    </nav>

    <!-- Contenedor flex para alinear el título y el botón -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Movimientos de caja</h1>

        <a href="{{ route('cajas.index') }}"
           class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" /> Volver
        </a>
    </div>

    <!-- Panel de datos -->
    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 mb-6">
        <h2 class="text-lg font-semibold mb-4">Caja de {{ $caja->user->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
            <p><strong>Apertura:</strong> {{ $caja->fecha_hora_apertura }}</p>
            <p><strong>Cierre:</strong> {{ $caja->fecha_hora_cierre ?? '-' }}</p>
            <p><strong>Saldo inicial:</strong> {{ number_format($caja->saldo_inicial, 2) }}</p>
            <p><strong>Saldo final:</strong> {{ $caja->saldo_final ? number_format($caja->saldo_final, 2) : '-' }}</p>
        </div>
    </div>

    <!-- Tabla de movimientos -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 p-4">
        <h3 class="font-bold mb-4 flex items-center"><x-heroicon-o-table-cells class="w-5 h-5 mr-2"/> Tabla movimientos</h3>
        <table class="w-full text-left text-gray-300">
            <thead class="border-b border-gray-700">
                <tr>
                    <th class="py-2">Tipo</th>
                    <th class="py-2">Descripción</th>
                    <th class="py-2">Monto</th>
                    <th class="py-2">Método de pago</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="py-10 text-center text-gray-500">No hay movimientos registrados aún.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
