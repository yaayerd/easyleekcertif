<?php

namespace App\Http\Requests\Api\Commande;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCommandeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'plat_id' => 'required|exists:plats,id', 
            'nombrePlats' => 'required|integer|min:1',
            'lieuLivraison' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'plat_id.required' => 'Le plat est obligatoire.',
            'plat_id.exists' => 'Le plat sélectionné n\'existe pas.',

            'nombrePlats.required' => 'Le nombre de plats est obligatoire.',
            'nombrePlats.integer' => 'Le nombre de plats doit être un nombre entier.',
            'nombrePlats.min' => 'Le nombre de plats doit être au moins égal à 1.',

            'lieuLivraison.required' => 'Lelieu de livraison est obligatoire.',
            'lieuLivraison.string' => 'Lelieu de livraison doit être une chaîne de caractères.',
            'lieuLivraison.max' => 'Lelieu de livraisonne peut pas dépasser 255 caractères.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'error'   => true,
            'message'   => 'Erreur de validation',
            'errorLists'  => $validator->errors()

        ]));
    }
}
