<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EstadiRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Només els administradors poden gestionar estadis
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules(): array
    {
        $estadiId = $this->route('estadi') ? $this->route('estadi')->id : '';

        return [
            'nom' => 'required|string|min:3|max:255|unique:estadis,nom,' . $estadiId,
            'capacitat' => 'required|integer|min:1000|max:100000',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'El nom de l\'estadi és obligatori.',
            'nom.min' => 'El nom ha de tenir almenys 3 caràcters.',
            'nom.unique' => 'Aquest estadi ja existeix.',
            'capacitat.required' => 'La capacitat és obligatòria.',
            'capacitat.integer' => 'La capacitat ha de ser un número enter positiu.',
            'capacitat.min' => 'La capacitat mínima és 1.000 espectadors.',
            'capacitat.max' => 'La capacitat màxima és 100.000 espectadors.',
        ];
    }
}
