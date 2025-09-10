<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            // Création : tous obligatoires
            return [
                'nom' => 'required|string|min:2',
                'description' => 'required|string',
                'prix' => 'required|numeric|min:1',
                'stock' => 'required|integer|min:0',
                'allergenes' => 'nullable|string',
                'id_categorie' => 'required|exists:categories,id',
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Modification : champs optionnels
            return [
                'nom' => 'sometimes|required|string|min:2',
                'description' => 'sometimes|required|string',
                'prix' => 'sometimes|required|numeric|min:1',
                'stock' => 'sometimes|required|integer|min:0',
                'allergenes' => 'nullable|string',
                'id_categorie' => 'sometimes|required|exists:categories,id',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }

        return [];
    }
}
