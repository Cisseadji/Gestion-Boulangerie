<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommandeRequest extends FormRequest
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
            'id_client' => 'required',
            'total'          => 'required',
            'statut' => 'required|in:EN_PREPARATION,PRETE,EN_LIVRAISON,LIVREE',
            'mode_paiement' => 'required|in:EN_LIGNE,A_LA_LIVRAISON',
            'date_commande'  => 'required'
        ];
    }
}
