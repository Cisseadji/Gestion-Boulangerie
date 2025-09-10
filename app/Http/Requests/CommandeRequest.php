<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'mode_paiement' => 'required|in:EN_LIGNE,A_LA_LIVRAISON',
            'adresse' => 'required|string',
            'date_commande' => 'required|date',
            'total' => 'required|numeric|min:1'
        ];

        if ($this->isMethod('post')) {
            $rules['produits'] = 'required|array|min:1';
            $rules['produits.*.id'] = 'required|exists:produits,id';
            $rules['produits.*.quantite'] = 'required|integer|min:1';
            $rules['produits.*.prix_unitaire'] = 'required|numeric|min:1';
        }

        return $rules;
    }
}
