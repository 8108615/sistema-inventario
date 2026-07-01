<?php

namespace App\Livewire\Cajas;

use Livewire\Component;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class GestionarCaja extends Component
{
    use WithPagination;

    public $search = '';
    public $saldo_inicial;
    public $nombre_caja = 'Caja Principal';

    protected $rules = [
        'saldo_inicial' => 'required|numeric|min:0',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function abrirCaja()
    {
        $this->validate();

        Caja::create([
            'nombre_caja' => $this->nombre_caja,
            'fecha_hora_apertura' => now(),
            'saldo_inicial' => $this->saldo_inicial,
            'user_id' => Auth::id(),
            'estado' => true
        ]);

        $this->reset(['saldo_inicial']);
        $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Caja aperturada correctamente']);
    }

    #[On('confirmar-cierre')]
    public function cerrarCaja($id)
    {
        $caja = Caja::find($id);
        if ($caja && $caja->estado) {
            $caja->update([
                'fecha_hora_cierre' => now(),
                'saldo_final' => $caja->saldo_inicial, // Aquí podrías sumar las ventas realizadas
                'estado' => false
            ]);
            $this->dispatch('alerta', ['tipo' => 'success', 'mensaje' => 'Caja cerrada correctamente']);
        }
    }

    public function render()
    {
        // 1. Lógica para obtener el símbolo
        $empresa = \App\Models\Empresa::first();
        $simboloMoneda = '$';

        $path = public_path('divisas.json');
        if (File::exists($path)) {
            $divisas = json_decode(File::get($path), true);
            if ($empresa && isset($divisas[$empresa->divisa])) {
                $simboloMoneda = $divisas[$empresa->divisa]['symbol'];
            }
        }

        $cajas = Caja::with('user')
            ->whereHas('user', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.cajas.gestionar-caja', [
            'cajas' => $cajas,
            'simboloMoneda' => $simboloMoneda // Pasamos la variable
        ]);
    }
}
