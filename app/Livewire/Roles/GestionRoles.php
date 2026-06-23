<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class GestionRoles extends Component
{

    use WithPagination;

    public $name, $role_id;
    public $search = '';
    public $isModalOpen = false;
    public $isPermissionModalOpen = false;
    public $permisosAsignados = [];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }

    public function guardar()
    {
        $this->validate(['name' => 'required|unique:roles,name,' . $this->role_id]);

        $esEdicion = !empty($this->role_id);
        Role::updateOrCreate(['id' => $this->role_id], ['name' => mb_strtoupper($this->name, 'UTF-8')]);

        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => $esEdicion ? 'Rol actualizado' : 'Rol creado']);
        $this->reset(['name', 'role_id']);
        $this->isModalOpen = false;
    }

    public function editar($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->isModalOpen = true;
    }

    public function confirmarEliminar($id)
    {
        $role = Role::findOrFail($id);
        $this->dispatch('confirmar-eliminacion', ['id' => $id, 'nombre' => $role->name]);
    }

    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $role = Role::find($id);
        if($role) {
            $role->delete();
            $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Rol eliminado']);
        }
    }

    public function toggleModal() { $this->isModalOpen = !$this->isModalOpen; }

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')->paginate(5);
        return view('livewire.roles.gestion-roles', compact('roles'))->layout('layouts.app');
    }

    public function abrirPermisos($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        // Cargar permisos actuales del rol
        $this->permisosAsignados = $role->permissions->pluck('name')->toArray();
        $this->isPermissionModalOpen = true;
    }

    public function guardarPermisos()
    {
        $role = Role::findOrFail($this->role_id);
        $role->syncPermissions($this->permisosAsignados);
        
        $this->isPermissionModalOpen = false;
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Permisos actualizados']);
    }
}