<div class="p-6 space-y-6">
    <!-- Encabezado con título dinámico y botón Volver -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-white uppercase tracking-wider">Editar Venta: {{ $venta->numero_comprobante }}</h2>

        <a href="{{ route('ventas.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded font-bold uppercase text-sm flex items-center transition">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
            Volver
        </a>
    </div>

    <!-- 1. Datos generales -->
    <div class="border border-green-600 rounded">
        <div class="bg-green-600 text-white p-2 font-bold uppercase text-sm">1. Datos generales</div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-800">
            <div>
                <label class="text-gray-300 text-xs uppercase">Cliente</label>
                <select wire:model="cliente_id" class="w-full bg-gray-900 text-white p-2 rounded border border-gray-700">
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $c) <option value="{{$c->id}}">{{$c->nombre_cliente}}</option> @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="text-gray-300 text-xs uppercase">Comprobante</label>
                    <select wire:model="tipo_comprobante" class="w-full bg-gray-900 text-white p-2 rounded border border-gray-700">
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                    </select>
                </div>
                <div>
                    <label class="text-gray-300 text-xs uppercase">Pago</label>
                    <select wire:model.live="metodo_pago" class="w-full bg-gray-900 text-white p-2 rounded border border-gray-700">
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TARJETA">TARJETA</option>
                        <option value="TRASFERENCIA">TRASFERENCIA</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-gray-900 p-2 rounded border border-gray-700">
                <input type="checkbox" wire:model.live="con_impuesto" id="chkImpuesto" class="w-5 h-5 accent-green-600">
                <label for="chkImpuesto" class="text-white font-bold cursor-pointer">INCLUIR IMPUESTO (13%)</label>
            </div>
        </div>
    </div>

    <!-- 2. Selección de productos -->
    <div class="border border-blue-600 rounded">
        <div class="bg-blue-600 text-white p-2 font-bold uppercase text-sm">2. Selección de productos</div>
        <div class="p-4 bg-gray-800">
            <label class="text-gray-300 text-xs uppercase">Producto</label>
            <select wire:model.live="producto_id" class="w-full bg-gray-900 text-white p-2 mb-4 rounded border border-gray-700">
                <option value="">Buscar producto...</option>
                @foreach($productos as $p)
                    <option value="{{$p->id}}">{{$p->nombre_producto}}</option>
                @endforeach
            </select>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <input type="text" readonly value="Stock: {{ $stock_actual ?? 0 }}" class="bg-gray-900 text-gray-400 p-2 rounded border border-gray-700 text-center">
                <input type="text" readonly value="Precio: {{ $precio_venta ?? 0 }}" class="bg-gray-900 text-gray-400 p-2 rounded border border-gray-700 text-center">
                <input type="number" wire:model="cantidad" class="bg-gray-900 text-white p-2 rounded border border-gray-700 text-center" placeholder="Cant.">
            </div>
            <div class="flex justify-end">
                <button wire:click="agregarAlCarrito" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold uppercase">
                    Agregar al carrito
                </button>
            </div>
        </div>
    </div>

    <!-- 3. Tabla del carrito -->
    <div class="bg-gray-800 rounded border border-gray-700 overflow-hidden">
        <table class="w-full text-white text-sm">
            <thead class="bg-gray-900 uppercase">
                <tr><th class="p-3">Producto</th><th class="p-3">Cant</th><th class="p-3">Precio</th><th class="p-3">Subtotal</th><th class="p-3">Acción</th></tr>
            </thead>
            <tbody>
                @foreach($carrito as $index => $item)
                <tr class="border-t border-gray-700 text-center">
                    <td class="p-3">{{$item['nombre']}}</td>
                    <td class="p-3">{{$item['cantidad']}}</td>
                    <td class="p-3">{{ number_format($item['precio'], 2) }}</td>
                    <td class="p-3">{{ number_format($item['subtotal'], 2) }}</td>
                    <td class="p-3">
                        <button wire:click="eliminarProducto({{$index}})" class="text-red-500 hover:text-red-400 font-bold">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Cálculo de totales en tiempo real -->
        @php
            $subtotal_calculado = collect($carrito)->sum('subtotal');
            $impuesto_calculado = $con_impuesto ? $subtotal_calculado * 0.13 : 0;
            $total_calculado = $subtotal_calculado + $impuesto_calculado;
        @endphp

        <div class="bg-gray-900 p-4 text-white text-right space-y-1 font-bold">
            <div>SUBTOTAL: {{ number_format($subtotal_calculado, 2) }}</div>
            <div class="text-blue-400">IMPUESTO ({{ $con_impuesto ? '13%' : '0%' }}): {{ number_format($impuesto_calculado, 2) }}</div>
            <div class="text-2xl pt-2 border-t border-gray-700">
                TOTAL A PAGAR: {{ number_format($total_calculado, 2) }}
            </div>
        </div>
    </div>

    <div class="border border-green-600 rounded bg-gray-800 p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

        @if($metodo_pago !== 'EFECTIVO')
            <div>
                <label class="text-gray-300 text-xs uppercase block">Cód. Transacción</label>
                <input type="text" wire:model="codigo_transaccion" class="w-full bg-gray-900 text-white p-2 rounded border border-gray-700" placeholder="Ej: 123456">
            </div>
        @else
            <div></div> @endif

        <div>
            <label class="text-gray-300 text-xs uppercase block">Dinero Recibido</label>
            <input type="number" step="0.01" wire:model.live="monto_recibido"
                {{ $metodo_pago !== 'EFECTIVO' ? 'disabled' : '' }}
                class="w-full {{ $metodo_pago !== 'EFECTIVO' ? 'bg-gray-700 cursor-not-allowed' : 'bg-gray-900' }} text-white p-2 rounded border border-gray-700">
        </div>

        <div>
            <label class="text-gray-300 text-xs uppercase block">Vuelto a Entregar</label>
            <input type="text" readonly
                value="{{ $metodo_pago !== 'EFECTIVO' ? '0.00' : number_format(($monto_recibido ?? 0) - $total_calculado, 2) }}"
                class="w-full bg-gray-700 text-white p-2 rounded border border-gray-700 font-bold">
        </div>

        <button wire:click="actualizarVenta" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded font-bold uppercase">
            Actualizar Venta
        </button>
    </div>
</div>
