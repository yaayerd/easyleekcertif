<?php

namespace App\Http\Requests\Api\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMenuRequest extends FormRequest
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
            "titre" => 'required|min:5|max:30|unique:menus',
            // "type_menu" => 'required|in:plat,dessert',
            // "description" => 'nullable|string|max:255'
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
            'titre.required' => 'Le titre du menu est obligatoire, veuillez le renseigner.',
            'titre.min' => 'Le titre du menu ne peut pas contenir moins de 5 caractères.',
            'titre.max' => 'Le titre du menu ne peut pas dépasser 30 caractères.',
            'titre.unique' => 'Ce nom du menu est déjà utilisé.',
            ];
    }
}
