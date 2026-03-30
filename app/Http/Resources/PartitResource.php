<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'jornada' => $this->jornada,
            'data_partit' => $this->data_partit,
            'gols_local' => $this->gols_local,
            'gols_visitant' => $this->gols_visitant,
            'equip_local' => new EquipResource($this->whenLoaded('equipLocal')),
            'equip_visitant' => new EquipResource($this->whenLoaded('equipVisitant')),
            'arbitre' => $this->arbitre?->name,
        ];
    }
}
