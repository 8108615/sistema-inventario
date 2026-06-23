<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Importante para gestionar imágenes
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GestionUsuarios extends Component
{
    use WithPagination, WithFileUploads, AuthorizesRequests;

    public $name, $email, $password, $password_confirmation, $image, $role, $user_id;
    public $isModalOpen = false;
    public $search = '';

    public $user_id_eliminar;

    public function guardar()
    {
        $this->user_id ? $this->authorize('usuarios.editar') : $this->authorize('usuarios.crear');

        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required',
            'image' => 'nullable|image|max:1024',
        ];

        if (!$this->user_id) {
            // Usuario nuevo: ambas son obligatorias
            $rules['password'] = 'required|min:8|same:password_confirmation';
        } else {
            // Edición: solo si el usuario decide escribir una nueva contraseña
            if ($this->password) {
                $rules['password'] = 'min:8|same:password_confirmation';
            }
        }

        $this->validate($rules);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $userData['password'] = bcrypt($this->password);
        }

        // --- AJUSTE AQUÍ: Verificamos si hay usuario existente ANTES de intentar borrar ---
        if ($this->image) {
            if ($this->user_id) {
                $usuarioExistente = User::find($this->user_id);
                if ($usuarioExistente && $usuarioExistente->image) {
                    Storage::disk('public')->delete($usuarioExistente->image);
                }
            }
            $userData['image'] = $this->image->store('profiles', 'public');
        }

        $esNuevo = is_null($this->user_id);
        $user = User::updateOrCreate(['id' => $this->user_id], $userData);
        $user->syncRoles([$this->role]);

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'image', 'role', 'user_id']);
        $this->isModalOpen = false;

        $mensaje = $esNuevo ? 'Guardado correctamente' : 'Actualizado correctamente';
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => $mensaje]);
    }

    public function editar($id)
    {
        $this->authorize('usuarios.editar');

        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()->first();
        $this->isModalOpen = true;
    }

    public function confirmarEliminar($id)
    {
        $user = User::findOrFail($id);
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => $user->name
        ]);
    }

    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $this->authorize('usuarios.eliminar');
        $user = User::findOrFail($id);

        // Si es SUPER ADMIN, bloqueamos la acción aunque intenten dispararla
        if ($user->hasRole('SUPER ADMIN')) {
            $this->dispatch('alerta', ['tipo' => 'error', 'mensaje' => 'No puedes eliminar al administrador']);
            return;
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Usuario eliminado correctamente']);
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->paginate(10);

        return view('livewire.usuarios.gestion-usuarios', compact('usuarios'))->layout('layouts.app');
    }
}
