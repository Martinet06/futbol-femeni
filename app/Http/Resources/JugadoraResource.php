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
            'partits_jugats' => $this->partits->count(), // Exemple de relació
            'mitjana_gols' => $this->partits->avg('gols'), // Camps derivats
        ];
    }
}
