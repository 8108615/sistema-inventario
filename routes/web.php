<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categorias\GestionCategorias;
use App\Livewire\Productos\CrearProducto;
use App\Livewire\Productos\EditarProducto;
use App\Livewire\Productos\GestionProductos;
use App\Livewire\Productos\VerProducto;
use App\Livewire\Sucursales\GestionSucursales;
use App\Livewire\Roles\GestionRoles;
use App\Livewire\Usuarios\GestionUsuarios;
use App\Livewire\Proveedores\GestionProveedores;
use App\Livewire\Productos\ListadoProductos;
use App\Livewire\Lotes\GestionLotes;
use App\Livewire\Lotes\RegistroLotes;
use App\Livewire\Lotes\EditarLote;
use App\Livewire\Dashboard\Panel;
use App\Livewire\Compras\RegistrarCompra;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', Panel::class)->name('dashboard');

    // Gestión del Sistema de Inventario
    Route::get('categorias', GestionCategorias::class)->name('categorias.index')->middleware('can:categorias.ver');
    Route::get('sucursales', GestionSucursales::class)->name('sucursales.index')->middleware('can:sucursales.ver');
    Route::get('roles', GestionRoles::class)->name('roles.index')->middleware('can:roles.ver');
    Route::get('usuarios', GestionUsuarios::class)->name('usuarios.index')->middleware('can:usuarios.ver');
    Route::get('proveedores', GestionProveedores::class)->name('proveedores.index')->middleware('can:proveedores.ver');



    Route::get('/productos', ListadoProductos::class)->name('productos.index');
    Route::get('/productos/crear', CrearProducto::class)->name('productos.crear');
    Route::get('/productos/{producto}/editar', EditarProducto::class)->name('productos.editar');
    Route::get('/productos/{producto}/ver', VerProducto::class)->name('productos.ver');

    Route::get('lotes', GestionLotes::class)->name('lotes.index');
    Route::get('lotes/registrar', RegistroLotes::class)->name('lotes.registrar');
    Route::get('/lotes/{lote}/editar', EditarLote::class)->name('lotes.editar');

    Route::get('/compras/registrar', RegistrarCompra::class)->name('compras.registrar');

});

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
