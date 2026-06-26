<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-100">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-gray-900 border-r border-gray-800 hidden md:block">
            <div class="p-6 text-white font-bold text-xl border-b border-gray-800">
                SISTEMA INVENTARIO
            </div>
            <nav class="mt-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" />
                    Panel
                </a>
                @can('usuarios.ver')
                    <a href="{{ route('usuarios.index') }}"
                        class="flex items-center px-6 py-3 transition {{ request()->routeIs('usuarios.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <x-heroicon-o-users class="w-5 h-5 mr-3" />
                        Usuarios
                    </a>
                @endcan
                @can('roles.ver')
                    <a href="{{ route('roles.index') }}"
                        class="flex items-center px-6 py-3 transition {{ request()->routeIs('roles.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <x-heroicon-o-shield-check class="w-5 h-5 mr-3" />
                        Roles
                    </a>
                @endcan
                @can('categorias.ver')
                    <a href="{{ route('categorias.index') }}"
                        class="flex items-center px-6 py-3 transition {{ request()->routeIs('categorias.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <x-heroicon-o-tag class="w-5 h-5 mr-3" />
                        Categorías
                    </a>
                @endcan
                @can('sucursales.ver')
                    <a href="{{ route('sucursales.index') }}"
                        class="flex items-center px-6 py-3 transition {{ request()->routeIs('sucursales.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <x-heroicon-o-building-office class="w-5 h-5 mr-3" />
                        Sucursales
                    </a>
                @endcan

               @can('proveedores.ver')
                    <a href="{{ route('proveedores.index') }}"
                        class="flex items-center px-6 py-3 transition {{ request()->routeIs('proveedores.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <x-heroicon-o-truck class="w-5 h-5 mr-3" />
                        Proveedores
                    </a>
                @endcan

                <a href="{{ route('productos.index') }}"
                    class="flex items-center px-6 py-3 transition {{ request()->routeIs('productos.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <x-heroicon-o-shopping-bag class="w-5 h-5 mr-3" />
                    Productos
                </a>

                <a href="{{ route('lotes.index') }}"
                class="flex items-center px-6 py-3 transition {{ request()->routeIs('lotes.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <x-heroicon-o-archive-box-arrow-down class="w-5 h-5 mr-3" />
                Lotes
            </a>




            </nav>
        </aside>

        <div class="flex-1 flex flex-col">

            <header class="bg-gray-900 border-b border-gray-800 h-16 flex items-center justify-end px-6">
                <livewire:layout.navigation />
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        window.addEventListener('alerta', event => {
            Swal.fire({
                position: "top-end",
                icon: event.detail[0].tipo,
                title: event.detail[0].mensaje,
                showConfirmButton: false,
                timer: 2000
            });
        });

        window.addEventListener('confirmar-eliminacion', event => {
            Swal.fire({
                // Cambiamos el título a algo genérico o dinámico
                title: "¿Estás seguro?",
                text: "¿Deseas eliminar: " + event.detail[0].nombre + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminar-confirmado', { id: event.detail[0].id });
                }
            });
        });
    </script>

    @if (session()->has('alerta_exito'))
        <script>
            // Este bloque se ejecuta cuando hay una redirección
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('alerta_exito') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
</body>
</html>
