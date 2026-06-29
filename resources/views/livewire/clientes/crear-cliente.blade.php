<div class="p-6">
    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700 text-white shadow-lg">

        <h2 class="bg-blue-600 text-white p-4 rounded mb-6 font-bold text-lg shadow-md border-l-4 border-blue-900">
            Registrar Nuevo Cliente
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Nombre -->
            <div>
                <label class="block text-sm font-bold mb-2">Nombre Completo (*)</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model="nombre_cliente" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>

            <!-- Tipo Persona -->
            <div>
                <label class="block text-sm font-bold mb-2">Tipo de Persona</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-user-tag"></i></span>
                    <select wire:model.live="tipo_persona" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                        <option value="Natural">Persona Natural</option>
                        <option value="Juridico">Persona Jurídica</option>
                    </select>
                </div>
            </div>

            <!-- Razón Social (Condicional) -->
            @if($tipo_persona == 'Juridico')
            <div>
                <label class="block text-sm font-bold mb-2">Razón Social</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-building"></i></span>
                    <input type="text" wire:model="razon_social" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>
            @endif

            <!-- Tipo Documento -->
            <div>
                <label class="block text-sm font-bold mb-2">Tipo de Documento</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-id-card"></i></span>
                    <select wire:model="tipo_documento" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                        <option value="CI">CI</option>
                        <option value="NIT">NIT</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
            </div>

            <!-- Nro Documento -->
            <div>
                <label class="block text-sm font-bold mb-2">Nro Documento (*)</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-hashtag"></i></span>
                    <input type="text" wire:model="numero_documento" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>

            <!-- NIT -->
            <div>
                <label class="block text-sm font-bold mb-2">NIT</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-file-invoice"></i></span>
                    <input type="text" wire:model="nit" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-bold mb-2">Teléfono</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-phone"></i></span>
                    <input type="text" wire:model="telefono" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-bold mb-2">Email</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-envelope"></i></span>
                    <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>

            <!-- Dirección -->
            <div class="col-span-1">
                <label class="block text-sm font-bold mb-2">Dirección</label>
                <div class="relative flex items-center">
                    <span class="absolute ml-3 text-gray-400"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" wire:model="direccion" class="w-full bg-gray-900 border border-gray-600 p-2 pl-10 rounded">
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-2">
            <button wire:click="store" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold transition">
                <i class="fas fa-save mr-2"></i> Guardar Cliente
            </button>
            <a href="{{ route('clientes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded font-bold transition">
                <i class="fas fa-times mr-2"></i> Cancelar
            </a>
        </div>
    </div>
</div>
