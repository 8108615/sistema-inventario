<?php

namespace App\Livewire\Empresa;

use Livewire\Component;
use App\Models\Empresa;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class GestionEmpresa extends Component
{
    use WithFileUploads;

    public $empresa_id;
    public $nombre, $propietario, $nit, $porcentaje_impuesto, $abreviatura_impuesto, $direccion, $correo, $telefono, $divisa, $logo, $web, $logo_actual;
    public $lista_divisas = [];

    public function mount()
    {
        $path = public_path('divisas.json');
        if (File::exists($path)) {
            $this->lista_divisas = json_decode(File::get($path), true);
        }

        $empresa = Empresa::first();
        if ($empresa) {
            $this->empresa_id = $empresa->id;
            $this->nombre = $empresa->nombre;
            $this->propietario = $empresa->propietario;
            $this->nit = $empresa->nit;
            $this->porcentaje_impuesto = $empresa->porcentaje_impuesto;
            $this->abreviatura_impuesto = $empresa->abreviatura_impuesto;
            $this->direccion = $empresa->direccion;
            $this->correo = $empresa->correo;
            $this->telefono = $empresa->telefono;
            $this->divisa = $empresa->divisa;
            $this->web = $empresa->web;
            $this->logo_actual = $empresa->logo;
        }
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required',
            'propietario' => 'required',
            'nit' => 'required',
            'porcentaje_impuesto' => 'required|numeric',
            'abreviatura_impuesto' => 'required',
            'direccion' => 'required',
            'divisa' => 'required'
        ];

        $data = $this->validate($rules);
        $data['correo'] = $this->correo;
        $data['telefono'] = $this->telefono;
        $data['web'] = $this->web;

        // Lógica para reemplazar el logo
        if ($this->logo) {
            // Si ya existe un logo guardado, lo eliminamos físicamente
            if ($this->logo_actual) {
                Storage::disk('public')->delete($this->logo_actual);
            }

            // Guardamos la nueva imagen y asignamos la nueva ruta a $data
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        if ($this->empresa_id) {
            // Actualizamos la empresa existente
            Empresa::find($this->empresa_id)->update($data);

            // Si se subió un logo nuevo, actualizamos la referencia local
            if ($this->logo) {
                $this->logo_actual = $data['logo'];
            }

            session()->flash('message', 'Datos actualizados exitosamente.');
        } else {
            // Creamos una nueva empresa
            $empresa = Empresa::create($data);
            $this->empresa_id = $empresa->id;
            $this->logo_actual = $empresa->logo;

            session()->flash('message', 'Datos de la empresa registrados correctamente.');
        }
    }

    public function render()
    {
        return view('livewire.empresa.gestion-empresa');
    }
}
