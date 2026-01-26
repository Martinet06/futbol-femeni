<?php

namespace App\Http\Requests;

use App\Models\Equip;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Equip::class);
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|min:3|max:255|unique:equips,nom',
            'estadi_id' => 'required|integer|exists:estadis,id',
            'titols' => 'required|integer|min:0|max:100',
            'escut' => 'nullable|image|mimes:png|max:1024', // només .png i màx 1MB
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'El camp "Nom" és obligatori.',
            'nom.min' => 'El nom ha de tenir almenys 3 caràcters.',
            'nom.unique' => 'Aquest nom ja està en ús. Si us plau, tria un altre.',
            'titols.required' => 'El camp "Títols" és obligatori.',
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
