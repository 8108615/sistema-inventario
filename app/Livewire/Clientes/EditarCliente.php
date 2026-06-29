<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class EditarCliente extends Component
{
    public $cliente_id, $nombre_cliente, $tipo_persona, $razon_social, $nit, $direccion, $telefono, $email, $tipo_documento, $numero_documento, $estado;

    public function mount($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->cliente_id = $cliente->id;
        $this->nombre_cliente = $cliente->nombre_cliente;
        $this->tipo_persona = $cliente->tipo_persona;
        $this->razon_social = $cliente->razon_social;
        $this->nit = $cliente->nit;
        $this->direccion = $cliente->direccion;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->tipo_documento = $cliente->tipo_documento;
        $this->numero_documento = $cliente->numero_documento;
        $this->estado = $cliente->estado;
    }

    public function update()
    {
        $this->validate([
            'nombre_cliente' => 'required',
            'numero_documento' => 'required',
        ]);

        $cliente = Cliente::find($this->cliente_id);
        $cliente->update([
            'nombre_cliente' => $this->nombre_cliente,
            'tipo_persona' => $this->tipo_persona,
            'razon_social' => $this->razon_social,
            'nit' => $this->nit,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'estado' => $this->estado
        ]);

        session()->flash('alerta_exito', 'Cliente actualizado exitosamente');
        return redirect()->route('clientes.index');
    }

    public function updatedTipoPersona($value)
    {
        if ($value === 'Natural') {
            $this->razon_social = null;
        }
    }

    public function render()
    {
        return view('livewire.clientes.editar-cliente');
    }
}
