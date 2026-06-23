<?php

namespace App\Livewire\Permisos;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class GestionPermisos extends Component
{
    use WithPagination;
    public $name, $permiso_id;
    public $isModalOpen = false;

    public function guardar()
    {
        $this->validate(['name' => 'required|unique:permissions,name,' . $this->permiso_id]);
        Permission::updateOrCreate(['id' => $this->permiso_id], ['name' => mb_strtolower($this->name)]);
        $this->reset(['name', 'permiso_id']);
        $this->isModalOpen = false;
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Permiso guardado']);
    }

    public function render()
    {
        return view('livewire.permisos.gestion-permisos', [
            'permisos' => Permission::paginate(10)
        ])->layout('layouts.app');
    }
}