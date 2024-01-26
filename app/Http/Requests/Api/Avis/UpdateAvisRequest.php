<?php

namespace App\Http\Requests\Api\Avis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAvisRequest extends FormRequest
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
            'commande_id' => 'exists:commandes,id', 
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            // 'commande_id.required' => 'La commande est obligatoire pour faire un avis.',
            'commande_id.exists' => 'La commande sélectionnée n\'existe pas.',

            'note.required' => 'La note est obligatoire.',
            'note.integer' => 'La note doit être un nombre entier.',
            'note.min' => 'La note doit être compris entre 1 et 5 étoiles.',
            'note.max' => 'La note doit être compris entre 1 et 5 étoiles.',

            'commentaire.string' => 'Le commentaire doit être une chaîne de caractères.',
            'commentaire.max' => 'Le commentaire ne peut pas dépasser 255 caractères.',
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
