<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Aquest FormRequest no s'utilitza directament
        // S'utilitzen StoreJugadoraRequest i UpdateJugadoraRequest
        return false;
    }

    public function rules(): array
    {
        return [];
    }
}
