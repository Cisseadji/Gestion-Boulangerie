<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'telephone' => 'required',
            'role' => 'required|in:ADMIN,EMPLOYE,CLIENT',
        ];

        if ($this->isMethod('post')) {
            // ✅ Création → password obligatoire
            $rules['password'] = 'required|min:6';
        } else {
            // ✅ Update → password optionnel
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
}
