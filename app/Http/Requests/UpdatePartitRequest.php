<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equip_local_id' => 'required|exists:equips,id|different:equip_visitant_id',
            'equip_visitant_id' => 'required|exists:equips,id',
            'data_partit' => 'required|date',
            'gol_local' => 'nullable|integer|min:0',
            'gol_visitant' => 'nullable|integer|min:0',
        ];
    }
}
