<?php

namespace App\Livewire;

use App\Services\PartitService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ClassificacioComponent extends Component
{
    public $classificacio;
    public $temporada = '2024-2025';

    public function mount(PartitService $service)
    {
        $this->actualitzarClassificacio($service);
    }

    public function actualitzarClassificacio(PartitService $service)
    {
        $this->classificacio = $service->classificacio();
    }

    public function render()
    {
        return view('livewire.classificacio-component', [
            'classificacio' => $this->classificacio,
        ]);
    }
}
