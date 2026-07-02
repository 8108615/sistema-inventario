<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class EditarCliente extends Component
{
    public $cliente_id, $nombre_cliente, $tipo_persona, $razon_social, $nit, $direccion, $telefono, $email, $tipo_documento, $numero_documento, $estado;


    protected $rules = [
        'nombre_cliente'   => 'required|min:3',
        'tipo_documento'   => 'required',
        'numero_documento' => 'required',
        'email'            => 'nullable|email',
    ];

    public function mount(Cliente $cliente)
    {
        $this->cliente_id       = $cliente->id;
        $this->nombre_cliente   = $cliente->nombre_cliente;
        $this->tipo_persona     = $cliente->tipo_persona;
        $this->razon_social     = $cliente->razon_social;
        $this->nit              = $cliente->nit;
        $this->direccion        = $cliente->direccion;
        $this->telefono         = $cliente->telefono;
        $this->email            = $cliente->email;
        $this->tipo_documento   = $cliente->tipo_documento;
        $this->numero_documento = $cliente->numero_documento;
        $this->estado           = $cliente->estado;
    }

    public function update()
    {
        $this->validate();

        Cliente::find($this->cliente_id)->update([
            'nombre_cliente'   => $this->nombre_cliente,
            'tipo_persona'     => $this->tipo_persona,
            'razon_social'     => $this->razon_social,
            'nit'              => $this->nit,
            'direccion'        => $this->direccion,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'tipo_documento'   => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'estado'           => $this->estado
        ]);

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Cliente actualizado exitosamente'
        ]);

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
