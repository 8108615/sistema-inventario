<?php

namespace App\Livewire\Categorias;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GestionCategorias extends Component
{
    use WithPagination, AuthorizesRequests;
    public $nombre, $descripcion, $categoria_id;
    public $isModalOpen = false;
    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage(); // Resetear página al buscar
    }

    public function guardar()
    {
        $this->categoria_id ? $this->authorize('categorias.editar') : $this->authorize('categorias.crear');
        $this->validate([
        'nombre' => 'required|min:3',
        'descripcion' => 'nullable'
        ]);

        // Determinamos si es edición
        $esEdicion = !empty($this->categoria_id);

        Categoria::updateOrCreate(['id' => $this->categoria_id], [
            'nombre' => mb_strtoupper($this->nombre, 'UTF-8'),
            'descripcion' => $this->descripcion,
            'estado' => true
        ]);

        $mensaje = $esEdicion ? 'Categoría actualizada correctamente' : 'Categoría guardada correctamente';

        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => $mensaje]);
        $this->reset(['nombre', 'descripcion', 'categoria_id']);
        $this->isModalOpen = false;
    }

    public function render()
    {
        $categorias = Categoria::where('nombre', 'like', '%' . $this->search . '%')
            ->paginate(5);

        return view('livewire.categorias.gestion-categorias', [
            'categorias' => $categorias
        ])->layout('layouts.app');

    }

    public function editar($id)
    {
        $this->authorize('categorias.editar');
        $categoria = Categoria::find($id);
        $this->categoria_id = $categoria->id;
        $this->nombre = $categoria->nombre;
        $this->descripcion = $categoria->descripcion; // <--- Verifica que esta línea exista
        $this->isModalOpen = true;
    }


    public function confirmarEliminar($id)
    {
        $this->authorize('categorias.eliminar');
        $categoria = Categoria::find($id);
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => $categoria->nombre
        ]);
    }

    #[On('eliminar-confirmado')]
    public function eliminar($id)
    {
        $this->authorize('categorias.eliminar');
        $categoria = Categoria::find($id);
        if($categoria) {
            $categoria->delete();
            // Disparamos la alerta de éxito después de eliminar
            $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Categoría eliminada correctamente']);
        }
    }

    public function toggleModal()
    {
        $this->isModalOpen = !$this->isModalOpen;
    }
}
