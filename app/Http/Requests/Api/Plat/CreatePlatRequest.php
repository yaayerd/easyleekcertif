<?php

namespace App\Http\Requests\Api\Plat;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlatRequest extends FormRequest
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
            'libelle' => 'required|string|min:3|max:50',
            'prix' => 'required|numeric|min:100',
            'descriptif' => 'required|string',
            'menu_id' => 'required|int',
            // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'libelle.required' => 'Le Libellé du plat est obligatoire.',
            'libelle.string' => 'Le Libellé du plat doit être une chaîne de caractères.',
            'libelle.min' => 'Le  Libellé du plat ne peut pas dépasser 3 caractères.',
            'libelle.max' => 'Le  Libellé du plat ne peut pas dépasser 50 caractères.',

            'prix.required' => 'Le prix du plat est obligatoire.',
            'prix.numeric' => 'Le  prix du plat doit être un nombre.',
            'prix.min' => 'Le prix du plat ne peut pas être inférieur à 100 Francs.',

            'descriptif.required' => 'Le descriptif du plat est obligatoire.',
            'descriptif.string' => 'Le descriptif du plat doit être une chaîne de caractères.',

            'menu_id.required' => "L'association d'un menu au plat est obligatoire.",
            'menu_id.numeric' => 'Le menu lié à ce plat doit être un nombre.',

            // 'image.image' => 'L\'image du plat doit être une image valide.',
            // 'image.mimes' => 'L\'image du plat doit être un fichier de type jpeg, png ou jpg.',
            // 'image.max' => 'L\'image du plat ne peut pas dépasser 2048 ko.',
            'image.required' => 'L\'image du plat est obligatoire.'   ,     
            'image.string' => 'L\'image du plat doit être en chaine de caractères.'  
        ];
    }
}
