<?php

namespace App\Livewire\Sucursales;

use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GestionSucursales extends Component
{
    use WithPagination, AuthorizesRequests;

    protected $layout = 'layouts.app';
    public $search = '';
    public $nombre, $direccion, $telefono, $estado = true, $sucursal_id;
    public $isOpen = false;

    protected $rules = [
        'nombre' => 'required|min:3',
        'direccion' => 'required',
        'telefono' => 'nullable',
    ];

    public function render()
    {
        $sucursales = Sucursal::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.sucursales.gestion-sucursales', compact('sucursales'))
            ->layout('layouts.app'); // <--- Esto es vital para que no te dé el "MissingLayoutException"
    }

    public function create() {
        $this->reset(['nombre', 'direccion', 'telefono', 'sucursal_id']);
        $this->isOpen = true;
    }

   public function store()
    {
        // Usamos $this->validate() directamente.
        // Como ya tienes $rules definido como propiedad, no necesitas pasarle nada.
        $this->sucursal_id ? $this->authorize('sucursales.editar') : $this->authorize('sucursales.crear');
        $this->validate();

        $esEdicion = !empty($this->sucursal_id);

        Sucursal::updateOrCreate(['id' => $this->sucursal_id], [
            'nombre' => mb_strtoupper($this->nombre, 'UTF-8'),
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'estado' => $this->estado,
        ]);

        $this->isOpen = false;
        $this->reset(['nombre', 'direccion', 'telefono', 'estado', 'sucursal_id']); // Limpiamos todo

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => $esEdicion ? 'Sucursal actualizada correctamente' : 'Sucursal creada correctamente'
        ]);
    }

    public function edit($id)
    {
        $this->authorize('sucursales.editar');
        $sucursal = Sucursal::findOrFail($id);
        $this->sucursal_id = $id;
        $this->nombre = $sucursal->nombre;
        $this->direccion = $sucursal->direccion;
        $this->telefono = $sucursal->telefono;
        $this->estado = $sucursal->estado;
        $this->isOpen = true;
    }

    public function updatedNombre($value)
    {
        $this->nombre = mb_strtoupper($value, 'UTF-8');
    }
    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function confirmarEliminar($id)
    {
        $this->authorize('sucursales.eliminar');
        $sucursal = Sucursal::find($id);
        // Disparamos un evento para que JS (SweetAlert) lo capture
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => $sucursal->nombre
        ]);
    }

    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $this->authorize('sucursales.eliminar');
        $sucursal = Sucursal::find($id);
        if($sucursal) {
            $sucursal->delete();
            $this->dispatch('alerta', [
                'tipo' => 'success',
                'mensaje' => 'Sucursal eliminada correctamente'
            ]);
        }
    }
}
