<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categorias\GestionCategorias;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('categorias', App\Livewire\Categorias\GestionCategorias::class)->name('categorias.index');
    Route::get('sucursales', \App\Livewire\Sucursales\GestionSucursales::class)->name('sucursales.index');
    Route::get('/roles', App\Livewire\Roles\GestionRoles::class)->name('roles.index');
    Route::get('/usuarios', App\Livewire\Usuarios\GestionUsuarios::class)->name('usuarios.index');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';
