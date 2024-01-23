<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:3|max:30',
            'email' => 'required|email|unique:users,email',
            // 'phone' => 'required|regex:#^\+221(?:76|77|78|70)[0-9]{7}$#',
            'phone' => 'required|integer',
            'adresse' => 'required|string|max:70',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:8',
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
            'name.required' => 'Le nom est obligatoire.',
            'name.min' => 'Le nom doit contenir au moins 3 caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 30 caractères.',

            'email.required' => 'L\'dresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée par un autre utilisateur.',

            'phone.required' => 'Le numéro de Téléphone est obligatoire.',
            'phone.regex' => 'Le "Téléphone" doit être un numéro sénégalais. Il doit commencer par +221 suivi de l\'un des préfixes (76, 77, 78, 70) et être suivi de 7 chiffres.',

            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 70 caractères.',

            'image.image' => 'L\'image doit être une image valide.',
            'image.mimes' => 'L\'image doit être un fichier de type jpeg, png ou jpg.',
            'image.max' => 'L\'image ne peut pas dépasser 2048ko.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ];
    }
}
