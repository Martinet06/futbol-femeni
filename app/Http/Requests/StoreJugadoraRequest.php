<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();
        $equipId = $this->input('equip_id');

        return $user->role === 'admin' ||
            ($user->role === 'manager' && $user->equip_id == $equipId);
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|min:3',
            'equip_id' => 'required|integer|exists:equips,id',
            'dorsal' => 'required|integer|min:1|max:99|unique:jugadores,dorsal,NULL,id,equip_id,' . $this->equip_id,
            'data_naixement' => 'required|date|before:today',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
