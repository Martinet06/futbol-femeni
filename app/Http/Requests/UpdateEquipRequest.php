<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $equip = $this->route('equip'); // Obté l'equip de la ruta
        return $this->user()->can('update', $equip);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $equipId = $this->route('equip')->id; // Obté l'ID de l'equip actual

        return [
            'nom' => 'sometimes|required|unique:equips,nom,' . $equipId,
            'titols' => 'sometimes|integer|min:0',
            'estadi_id' => 'sometimes|required|exists:estadis,id',
            'escut' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
