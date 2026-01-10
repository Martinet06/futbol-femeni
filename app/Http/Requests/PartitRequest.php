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
            'gols_local' => 'nullable|integer|min:0',
            'gols_visitant' => 'nullable|integer|min:0',
        ];
    }
}
