<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categorias\GestionCategorias;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('categorias', App\Livewire\Categorias\GestionCategorias::class)->name('categorias.index');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__.'/auth.php';
