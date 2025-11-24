<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jugadoraId = $this->route('jugadora')->id;

        return [
            'nom' => 'required|string|min:3',
            'equip_id' => 'required|integer|exists:equips,id',
            'dorsal' => 'required|integer|min:1|max:99|unique:jugadores,dorsal,' . $jugadoraId . ',id,equip_id,' . $this->equip_id,
            'data_naixement' => 'required|date|before:today',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
