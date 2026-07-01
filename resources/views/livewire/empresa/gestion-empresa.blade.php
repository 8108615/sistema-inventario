<div class="p-6 bg-gray-800 rounded-lg shadow-lg text-gray-100">
    <h2 class="text-xl font-bold mb-6 text-white border-b border-gray-700 pb-2">Ajustes del sistema</h2>

    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Campos existentes -->
            <div>
                <label class="block text-sm font-medium mb-1">Nombre de la Empresa<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-building"></i></span>
                    <input type="text" wire:model="nombre" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Propietario</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model="propietario" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">NIT<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-id-card"></i></span>
                    <input type="text" wire:model="nit" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Divisa<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-coins"></i></span>
                    <select wire:model="divisa" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                        <option value="">Seleccione...</option>
                        @foreach($lista_divisas as $code => $data)
                            <option value="{{ $code }}">{{ $data['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Porcentaje Impuesto (%)<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-percentage"></i></span>
                    <input type="number" wire:model="porcentaje_impuesto" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Abrev. Impuesto<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-tag"></i></span>
                    <input type="text" wire:model="abreviatura_impuesto" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Dirección<span class="text-red-500">(*)</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" wire:model="direccion" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Correo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-envelope"></i></span>
                    <input type="email" wire:model="correo" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Teléfono</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-phone"></i></span>
                    <input type="text" wire:model="telefono" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sitio Web</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-globe"></i></span>
                    <input type="text" wire:model="web" class="w-full bg-gray-700 border border-gray-600 text-white pl-10 p-2.5 rounded">
                </div>
            </div>

            <!-- Logo Institucional -->
            <div>
                <label class="block text-sm font-medium mb-1">Logo Institucional</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 border border-gray-600 rounded flex items-center justify-center bg-gray-700 overflow-hidden">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($logo_actual)
                            <img src="{{ asset('storage/' . $logo_actual) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-image text-gray-500 text-2xl"></i>
                        @endif
                    </div>
                    <input type="file" wire:model="logo" class="text-sm text-gray-400">
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded">Cancelar</button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Guardar</button>
        </div>
    </form>
</div>
