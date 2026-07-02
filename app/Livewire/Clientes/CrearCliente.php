<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class CrearCliente extends Component
{
    public $nombre_cliente, $tipo_persona = 'Natural', $razon_social, $nit, $direccion, $telefono, $email, $tipo_documento = 'CI', $numero_documento;


    protected $rules = [
        'nombre_cliente'   => 'required|min:3',
        'tipo_documento'   => 'required',
        'numero_documento' => 'required',
        'email'            => 'nullable|email',
    ];
    // Método para limpiar Razón Social si cambia a Natural
    public function updatedTipoPersona($value)
    {
        if ($value === 'Natural') {
            $this->razon_social = null;
        }
    }

    public function store()
    {
        $this->validate();

        Cliente::create([
            'nombre_cliente'   => $this->nombre_cliente,
            'tipo_persona'     => $this->tipo_persona,
            'razon_social'     => $this->razon_social,
            'nit'              => $this->nit,
            'direccion'        => $this->direccion,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'tipo_documento'   => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'estado'           => true
        ]);

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Cliente registrado exitosamente'
        ]);

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.clientes.crear-cliente');
    }
}
