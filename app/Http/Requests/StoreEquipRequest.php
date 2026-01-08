<?php

namespace App\Http\Requests;

use App\Models\Equip;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Equip::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom'    => 'required|min:3',
            'estadi_id' => 'required|integer|exists:estadis,id',
            'titols' => 'required|integer|min:0',
            'escut' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nom.required' => 'El camp "Nom" és obligatori.',
            'nom.unique' => 'Aquest nom ja està en ús. Si us plau, tria un altre.',
            'titols.integer' => 'El camp "Títols" ha de ser un número enter.',
            'titols.min' => 'El nombre de títols no pot ser inferior a zero.',
            'estadi_id.required' => 'El camp "Estadi" és obligatori.',
            'estadi_id.exists' => 'L\'estadi seleccionat no és vàlid.',
            'escut.image' => 'El camp "Escut" ha de ser una imatge.',
            'escut.mimes' => 'El camp "Escut" només accepta formats: jpeg, png, jpg.',
            'escut.max' => 'La mida de l\'escut no pot superar els 2 MB.',
        ];
    }
}
