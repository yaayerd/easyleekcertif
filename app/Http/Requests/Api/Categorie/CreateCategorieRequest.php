<?php

namespace App\Http\Requests\Api\Categorie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCategorieRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "type" => 'required|max:50|unique:categories|in:Ndeki,Cuisine Locale,Fast Food,Patisserie,Ndiogonal,Dibiterie,Tangana',
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

    public function messages()
    {
        return [
            'type.required' => 'Le type de catégorie est obligatoire, veuillez le renseigner.',
            'type.max' => 'Le type de catégorie ne peut pas dépasser 50 caractères.',
            'type.unique' => 'Ce type de catégorie est déjà enrégistré, veuillez en choisir un autre.',
            'type.in' => 'La valeur sélectionnée pour le type de catégories n\'est pas valide. Veuillez choisir parmi les options disponibles : Ndeki, Cuisine Locale, Fast Food, Patisserie, Ndiogonal.',    
        ];
    }
}
