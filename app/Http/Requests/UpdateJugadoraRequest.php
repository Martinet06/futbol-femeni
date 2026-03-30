<?php

namespace App\Http\Requests;

use App\Models\Jugadora;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();

        // Si no hi ha usuari, denega
        if (!$user) {
            return false;
        }

        // Si és admin, permet sempre
        if ($user->role === 'admin') {
            return true;
        }

        // Si és manager, necessitem validar l'equip
        if ($user->role === 'manager') {
            // Obtenim el paràmetre de la ruta (en el teu cas serà un ID string)
            $routeParam = $this->route('jugadora');

            // Busquem la jugadora manualment
            $jugadora = Jugadora::find($routeParam);

            // Denega si no trobem la jugadora o no coincideix l'equip
            return $jugadora && $user->equip_id == $jugadora->equip_id;
        }

        // Qualsevol altre rol: denega
        return false;
    }

    public function rules(): array
    {

        $jugadoraId = $this->route('jugadora');
        $jugadora = Jugadora::find($jugadoraId);
        //dd($jugadoraId);
        //dd($jugadora);

        return [
            'nom' => 'required|string|min:3|max:255',
            'equip_id' => 'required|integer|exists:equips,id',
            'dorsal' => [
                'required',
                'integer',
                'min:1',
                'max:99',
                Rule::unique('jugadores', 'dorsal')
                    ->ignore($jugadoraId)
                    ->where('equip_id', $this->input('equip_id'))
            ],
            'data_naixement' => [
                'required',
                'date',
                'before:today',
                'before_or_equal:' . now()->subYears(16)->format('Y-m-d')
            ],
            'foto' => 'nullable|image|mimes:png|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'El nom és obligatori.',
            'nom.min' => 'El nom ha de tenir almenys 3 caràcters.',
            'equip_id.required' => 'L\'equip és obligatori.',
            'dorsal.required' => 'El dorsal és obligatori.',
            'dorsal.min' => 'El dorsal ha de ser com a mínim 1.',
            'dorsal.max' => 'El dorsal ha de ser com a màxim 99.',
            'dorsal.unique' => 'Aquest dorsal ja està en ús en aquest equip.',
            'data_naixement.required' => 'La data de naixement és obligatòria.',
            'data_naixement.before' => 'La data de naixement ha de ser anterior a avui.',
            'data_naixement.before_or_equal' => 'La jugadora ha de tenir com a mínim 16 anys.',
            'foto.image' => 'El camp foto ha de ser una imatge.',
            'foto.mimes' => 'La foto només pot ser de tipus PNG.',
            'foto.max' => 'La mida màxima de la foto és 1MB.',
        ];
    }
}
