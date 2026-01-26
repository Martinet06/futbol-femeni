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
            'data_naixement' => [
                'required',
                'date',
                'before:today',
                'before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
            ],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'El nom és obligatori.',
            'nom.min' => 'El nom ha de tenir almenys 3 caràcters.',
            'equip_id.required' => 'L\'equip és obligatori.',
            'dorsal.required' => 'El dorsal és obligatori.',
            'dorsal.min' => 'El dorsal ha de ser com a mínim 1.',
            'dorsal.max' => 'El dorsal no pot ser més gran que 99.',
            'dorsal.unique' => 'El dorsal ja està en ús en aquest equip.',
            'data_naixement.required' => 'La data de naixement és obligatòria.',
            'data_naixement.date' => 'La jugadora ha de tenir com a mímim 16 anys',
            'foto.image' => 'La foto ha de ser una imatge vàlida.',
            'foto.mimes' => 'La foto ha de ser en format jpeg, png, jpg o gif.',
            'foto.max' => 'La foto no pot ser més gran que 2MB.',
        ];
    }
}
