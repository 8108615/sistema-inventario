<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use Livewire\Attributes\On;

class ListadoClientes extends Component
{
    use WithPagination; // Necesario para la paginación

    public $search = ''; // Propiedad para el buscador

    protected $listeners = ['eliminar-confirmado' => 'destroy'];

    // Esto limpia la paginación cada vez que el usuario escribe algo nuevo en el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Consulta que filtra por nombre o documento y pagina los resultados
        $clientes = Cliente::where('nombre_cliente', 'like', '%' . $this->search . '%')
            ->orWhere('numero_documento', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc') // Para ver siempre los últimos creados primero
            ->paginate(10); // Ajusta este número según cuántos quieras ver por página

        return view('livewire.clientes.listado-clientes', [
            'clientes' => $clientes
        ]);
    }

    public function confirmarEliminacion($id, $nombre)
    {
        $this->dispatch('confirmar-eliminacion', [
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    #[On('eliminar-confirmado')]
    public function destroy($id) // Recibe el array que envía JS
    {
        $cliente = Cliente::find($id);

        if ($cliente) {
            $cliente->delete();
            $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Cliente eliminado con éxito']);
        }
    }
}
