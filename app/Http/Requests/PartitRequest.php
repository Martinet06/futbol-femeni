<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PartitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $partit = $this->route('partit');

        // Si el paràmetre és un ID (int/string), carreguem el model
        if (is_numeric($partit) || is_string($partit)) {
            $partit = \App\Models\Partit::find($partit);
        }

        if (!$partit) {
            return false;
        }

        $user = Auth::user();

        return $user->role === 'admin' ||
            ($user->role === 'arbitre' && $user->id == $partit->arbitre_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gols_local' => 'nullable|integer|min:0|max:99',
            'gols_visitant' => 'nullable|integer|min:0|max:99',
        ];
    }

    public function messages()
    {
        return [
            'gols_local.integer' => 'Els gols de l\'equip local han de ser un nombre enter.',
            'gols_local.min' => 'Els gols de l\'equip local no poden ser negatius.',
            'gols_local.max' => 'Els gols de l\'equip local no poden ser més de 99.',
            'gols_visitant.integer' => 'Els gols de l\'equip visitant han de ser un nombre enter.',
            'gols_visitant.min' => 'Els gols de l\'equip visitant no poden ser negatius.',
            'gols_visitant.max' => 'Els gols de l\'equip visitant no poden ser més de 99.',
        ];
    }
}
