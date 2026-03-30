<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JugadoraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'equip' => $this->equip,
            'posicio' => $this->posicio,
            'dorsal' => $this->dorsal,
            'edat' => $this->edat,
            'partits_jugats' => $this->partits?->count() ?? 0,
            'mitjana_gols' => round($this->partits?->avg('gols') ?? 0, 2),
        ];
    }
}
