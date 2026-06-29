<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class VerCliente extends Component
{
    public $cliente;
    public $modalVisible = false;

    // Escuchamos el evento para abrir el modal
    protected $listeners = ['verCliente' => 'mostrar'];

    public function mostrar($id)
    {
        $this->cliente = Cliente::find($id);
        $this->modalVisible = true;
    }

    public function cerrar()
    {
        $this->modalVisible = false;
    }

    public function render()
    {
        return view('livewire.clientes.ver-cliente');
    }
}
