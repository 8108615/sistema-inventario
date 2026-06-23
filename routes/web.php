<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categorias\GestionCategorias;
use App\Livewire\Sucursales\GestionSucursales;
use App\Livewire\Roles\GestionRoles;
use App\Livewire\Usuarios\GestionUsuarios;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Gestión del Sistema de Inventario
    Route::get('categorias', GestionCategorias::class)->name('categorias.index')->middleware('can:categorias.ver');
    Route::get('sucursales', GestionSucursales::class)->name('sucursales.index')->middleware('can:sucursales.ver');
    Route::get('roles', GestionRoles::class)->name('roles.index')->middleware('can:roles.ver');
    Route::get('usuarios', GestionUsuarios::class)->name('usuarios.index')->middleware('can:usuarios.ver');
});

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
