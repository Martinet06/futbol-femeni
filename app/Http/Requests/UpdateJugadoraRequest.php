<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        $jugadora = $this->route('jugadora');
        $user = Auth::user();

        return $user->role === 'admin' ||
            ($user->role === 'manager' && $user->equip_id == $jugadora->equip_id);
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
