<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class CrearCliente extends Component
{
    public $nombre_cliente, $tipo_persona = 'Natural', $razon_social, $nit, $direccion, $telefono, $email, $tipo_documento = 'CI', $numero_documento;

    // Método para limpiar Razón Social si cambia a Natural
    public function updatedTipoPersona($value)
    {
        if ($value === 'Natural') {
            $this->razon_social = null;
        }
    }

    public function store()
    {
        $this->validate([
            'nombre_cliente' => 'required',
            'numero_documento' => 'required',
            'tipo_documento' => 'required',
            'email' => 'nullable|email', // Validación opcional pero correcta para emails
        ]);

        Cliente::create([
            'nombre_cliente' => $this->nombre_cliente,
            'tipo_persona' => $this->tipo_persona,
            'razon_social' => $this->razon_social,
            'nit' => $this->nit,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'estado' => true
        ]);

        session()->flash('alerta_exito', 'Cliente registrado exitosamente');

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.clientes.crear-cliente');
    }
}
