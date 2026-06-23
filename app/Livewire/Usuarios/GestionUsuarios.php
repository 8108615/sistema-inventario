<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class GestionUsuarios extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $email, $password, $password_confirmation, $image, $role, $user_id;
    public $isModalOpen = false;
    public $search = '';

    public function guardar()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required',
            'image' => 'nullable|image|max:1024',
        ];

        // Solo requerir contraseña si es nuevo usuario
        if (!$this->user_id) {
            $rules['password'] = 'required|min:8|same:password_confirmation';
        }

        $this->validate($rules);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $userData['password'] = bcrypt($this->password);
        }

        if ($this->image) {
            // Eliminar imagen anterior si existe
            $usuarioExistente = User::find($this->user_id);
            if ($usuarioExistente && $usuarioExistente->image) {
                Storage::disk('public')->delete($usuarioExistente->image);
            }
            $userData['image'] = $this->image->store('profiles', 'public');
        }

        $user = User::updateOrCreate(['id' => $this->user_id], $userData);
        $user->syncRoles([$this->role]);

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'image', 'role', 'user_id']);
        $this->isModalOpen = false;
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Usuario guardado']);
    }

    public function editar($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()->first();
        $this->isModalOpen = true;
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.usuarios.gestion-usuarios', compact('usuarios'))->layout('layouts.app');
    }
}