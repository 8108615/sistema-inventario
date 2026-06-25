<?php

namespace App\Livewire\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GestionProveedores extends Component
{
    use WithPagination, AuthorizesRequests;

    public $search = '';
    public $nombre, $telefono, $email, $direccion, $empresa, $notas, $estado = true, $proveedor_id;
    public $isOpen = false;

    protected $rules = [
        'nombre'    => 'required|min:3|max:255',
        'telefono'  => 'required|min:8|max:50',
        'email'     => 'required|email|max:150',
        'empresa'   => 'required|max:255',
        'direccion' => 'required|max:255',
        'notas'     => 'nullable|string',
        'estado'    => 'required|boolean',
    ];

    public function render()
    {
        $proveedores = Proveedor::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('empresa', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.proveedores.gestion-proveedores', compact('proveedores'))
            ->layout('layouts.app');
    }

    public function create() {
        $this->reset(['nombre', 'telefono', 'email', 'direccion', 'empresa', 'notas', 'estado', 'proveedor_id']);
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();
        $this->authorize($this->proveedor_id ? 'proveedores.editar' : 'proveedores.crear');

        Proveedor::updateOrCreate(['id' => $this->proveedor_id], [
            'nombre'    => mb_strtoupper(trim($this->nombre), 'UTF-8'),
            'telefono'  => trim($this->telefono),
            'email'     => trim($this->email),
            'direccion' => trim($this->direccion),
            'empresa'   => trim($this->empresa),
            'notas'     => $this->notas,
            'estado'    => $this->estado,
        ]);

        $this->isOpen = false;
        $this->reset(['nombre', 'telefono', 'email', 'direccion', 'empresa', 'notas', 'estado', 'proveedor_id']);

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => $this->proveedor_id ? 'Proveedor actualizado' : 'Proveedor creado'
        ]);
    }

    public function edit($id)
    {
        $this->authorize('proveedores.editar');
        $p = Proveedor::findOrFail($id);
        $this->proveedor_id = $p->id;
        $this->nombre = $p->nombre;
        $this->telefono = $p->telefono;
        $this->email = $p->email;
        $this->direccion = $p->direccion;
        $this->empresa = $p->empresa;
        $this->notas = $p->notas;
        $this->estado = $p->estado;
        $this->isOpen = true;
    }

    public function confirmarEliminar($id)
    {
        $this->authorize('proveedores.eliminar');
        $p = Proveedor::find($id);
        $this->dispatch('confirmar-eliminacion', ['id' => $id, 'nombre' => $p->nombre]);
    }

    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $this->authorize('proveedores.eliminar');
        Proveedor::find($id)->delete();
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Proveedor eliminado']);
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
