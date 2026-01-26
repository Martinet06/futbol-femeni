<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipRequest extends FormRequest
{
    public function authorize(): bool
    {
        $equip = $this->route('equip');
        return $this->user()->can('update', $equip);
    }

    public function rules(): array
    {
        $equipId = $this->route('equip')->id;

        return [
            'nom' => 'sometimes|required|string|min:3|max:255|unique:equips,nom,' . $equipId,
            'titols' => 'sometimes|integer|min:0|max:100',
            'estadi_id' => 'sometimes|required|integer|exists:estadis,id',
            'escut' => 'sometimes|nullable|image|mimes:png|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'El camp "Nom" és obligatori.',
            'nom.min' => 'El nom ha de tenir almenys 3 caràcters.',
            'nom.unique' => 'Aquest nom ja està en ús. Si us plau, tria un altre.',
            'titols.integer' => 'El camp "Títols" ha de ser un número enter.',
            'titols.min' => 'El nombre de títols no pot ser inferior a zero.',
            'titols.max' => 'El nombre màxim de títols és 100.',
            'estadi_id.required' => 'El camp "Estadi" és obligatori.',
            'estadi_id.exists' => 'L\'estadi seleccionat no és vàlid.',
            'escut.image' => 'El camp "Escut" ha de ser una imatge.',
            'escut.mimes' => 'El camp "Escut" només accepta format PNG.',
            'escut.max' => 'La mida de l\'escut no pot superar 1 MB.',
        ];
    }
}
