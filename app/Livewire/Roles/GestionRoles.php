<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GestionRoles extends Component
{

    use WithPagination, AuthorizesRequests;

    public $name, $role_id;
    public $search = '';
    public $isModalOpen = false;
    public $isPermissionModalOpen = false;
    public $permisosAsignados = [];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }

    public function guardar()
    {
        $this->role_id ? $this->authorize('roles.editar') : $this->authorize('roles.crear');
        // Validamos el nombre. Si es edición, ignoramos el ID actual para el unique
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->role_id
        ]);

        $esEdicion = !empty($this->role_id);
        Role::updateOrCreate(['id' => $this->role_id], ['name' => mb_strtoupper($this->name, 'UTF-8')]);

        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => $esEdicion ? 'Rol actualizado' : 'Rol creado']);
        $this->reset(['name', 'role_id']);
        $this->isModalOpen = false;
    }

    public function editar($id)
    {
        $this->authorize('roles.editar');
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
        $this->authorize('roles.eliminar');
        $role = Role::find($id);

        // Validamos que exista y que NO sea el SUPER ADMIN
        if($role && $role->name !== 'SUPER ADMIN') {
            $role->delete();
            $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Rol eliminado correctamente']);
        } else {
            $this->dispatch('alerta', ['tipo' => 'error', 'mensaje' => 'No puedes eliminar este rol de sistema']);
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
        $this->authorize('roles.editar');
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        // Cargar permisos actuales del rol
        $this->permisosAsignados = $role->permissions->pluck('name')->toArray();
        $this->isPermissionModalOpen = true;
    }

    public function guardarPermisos()
    {
        $this->authorize('roles.editar');
        $role = Role::findOrFail($this->role_id);
        $role->syncPermissions($this->permisosAsignados);

        $this->isPermissionModalOpen = false;
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Permisos actualizados']);
    }
}
