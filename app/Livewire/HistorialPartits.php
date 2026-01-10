<?php

namespace App\Livewire;

use App\Models\Partit;
use Livewire\Component;

class HistorialPartits extends Component
{
    public $partits;
    public $equip = '';
    public $data = '';

    public function mount()
    {
        $this->partits = Partit::with(['equipLocal', 'equipVisitant'])->get();
    }


    public function filtrar()
    {
        $this->partits = Partit::with(['equipLocal', 'equipVisitant'])
            ->when($this->equip, function ($query) {
                $query->whereHas('equipLocal', fn($q) => $q->where('nom', 'like', "%{$this->equip}%"))
                    ->orWhereHas('equipVisitant', fn($q) => $q->where('nom', 'like', "%{$this->equip}%"));
            })
            ->when($this->data, function ($query) {
                $query->whereDate('data', $this->data);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.historial-partits', ['partits' => $this->partits]);
    }
}
