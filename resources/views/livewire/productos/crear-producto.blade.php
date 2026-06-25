<div class="p-6 bg-gray-900 text-white">
    <h2 class="bg-blue-800 p-4 mb-6 font-bold uppercase rounded shadow-lg text-lg">Creación de Producto</h2>

    <div class="grid grid-cols-4 gap-8">
        <div class="col-span-3 space-y-6">

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Categoría (*)</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden focus-within:border-blue-500">
                        <div class="px-3 text-gray-500"><x-heroicon-o-tag class="w-5 h-5"/></div>
                        <select wire:model="categoria_id" class="w-full bg-transparent p-2 border-none focus:ring-0">
                            <option value="">Seleccione...</option>
                            @foreach($categorias as $cat) <option value="{{ $cat->id }}">{{ $cat->nombre }}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Código (*)</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden focus-within:border-blue-500">
                        <div class="px-3 text-gray-500"><x-heroicon-o-qr-code class="w-5 h-5"/></div>
                        <input wire:model.live="codigo_producto" class="w-full bg-transparent p-2 border-none focus:ring-0" placeholder="Ej. 10001">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Nombre (*)</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden focus-within:border-blue-500">
                        <div class="px-3 text-gray-500"><x-heroicon-o-shopping-bag class="w-5 h-5"/></div>
                        <input wire:model="nombre_producto" class="w-full bg-transparent p-2 border-none focus:ring-0" placeholder="Nombre del producto">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Descripción (*)</label>
                <textarea wire:model="descripcion" class="w-full h-32 bg-gray-800 border border-gray-700 p-2 rounded focus:border-blue-500 outline-none"></textarea>
            </div>

            <div class="grid grid-cols-6 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Precio Compra</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-currency-dollar class="w-4 h-4"/></div>
                        <input type="number" wire:model="precio_compra" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Precio Venta</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-currency-dollar class="w-4 h-4"/></div>
                        <input type="number" wire:model="precio_venta" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Stock Min.</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-arrow-down-circle class="w-4 h-4"/></div>
                        <input type="number" wire:model="stock_minimo" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Stock Max.</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-arrow-up-circle class="w-4 h-4"/></div>
                        <input type="number" wire:model="stock_maximo" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Stock Inicial</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-archive-box class="w-4 h-4"/></div>
                        <input type="number" wire:model="stock_actual" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm" placeholder="0">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Unidad</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-scale class="w-4 h-4"/></div>
                        <select wire:model="unidad_medida" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                            <option value="">...</option>
                            <option value="UNIDAD">UNIDAD</option>
                            <option value="LITROS">LITROS</option>
                            <option value="PAQUETES">PAQUETES</option>
                            <option value="CAJAS">CAJAS</option>
                            <option value="METROS">METROS</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Estado</label>
                    <div class="flex items-center bg-gray-800 border border-gray-700 rounded overflow-hidden">
                        <div class="px-2 text-gray-500"><x-heroicon-o-cog class="w-4 h-4"/></div>
                        <select wire:model="estado" class="w-full bg-transparent p-2 border-none focus:ring-0 text-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Imagen (*)</label>
                <div class="w-full h-40 bg-gray-800 border border-gray-700 rounded flex items-center justify-center text-gray-500 mb-2 overflow-hidden">
                    @if($imagen) <img src="{{ $imagen->temporaryUrl() }}" class="h-full w-full object-cover"> @else <span class="text-xs">Sin imagen</span> @endif
                </div>
                <input type="file" wire:model="imagen" class="text-xs w-full">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Código de Barra (*)</label>
                <input wire:model.live="codigo_barra" id="inputBarcode" class="w-full bg-gray-800 border border-gray-700 p-3 rounded text-center text-lg font-mono" placeholder="0000000000">
            </div>

            <div id="barcode-section" class="bg-white p-4 rounded flex flex-col justify-center items-center text-black border border-dashed border-gray-400">
                @if($barcodeImage)
                    <img src="data:image/png;base64,{{ $barcodeImage }}" alt="Código de barras" class="max-w-full">
                    <p class="text-xl font-extrabold text-black mt-2 tracking-widest">{{ $codigo_barra }}</p>



                    <button onclick="window.print()" class="mt-4 text-xs bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-700 transition print:hidden">
                        Imprimir Etiqueta
                    </button>
                @else
                    <p class="text-gray-400 text-sm">Esperando datos...</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-12 flex justify-end space-x-4 border-t border-gray-700 pt-6">
        <a href="{{ route('productos.index') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 rounded transition">Cancelar</a>
        <button type="button" wire:click="store" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 rounded transition font-bold">
            Guardar Producto
        </button>
    </div>
</div>

@push('styles')
    <style>
        @media print {
            /* Ocultamos todo el sistema */
            body * { visibility: hidden; }

            /* Mostramos solo nuestra etiqueta */
            #barcode-section, #barcode-section * { visibility: visible; }

            /* Posicionamiento para impresión */
            #barcode-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background-color: white !important;
                color: black !important;
                border: none !important;
            }
            #barcode-section img {
                max-width: 200px; /* Ajusta el tamaño de la imagen según tu papel */
                margin: 0 auto;
            }
        }
    </style>
@endpush
