<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipResource extends JsonResource
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
            'nom' => $this->nom,
            'escut' => $this->escut,
            'titols' => $this->titols,
            'estadi' => new EstadiResource($this->whenLoaded('estadi')),
            'created_at' => $this->created_at,
        ];
    }
}
