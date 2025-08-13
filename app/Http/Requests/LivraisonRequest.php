<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivraisonRequest extends FormRequest
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
            'id_commande'   => 'required',
            'adresse'       => 'required',
            'date_livraison'=> 'required|date|after_or_equal:today',
            'statut'        => 'required|in:EN_ATTENTE,EN_ROUTE,LIVREE'
        ];
    }
}
