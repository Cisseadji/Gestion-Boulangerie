<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            'nom'           => 'required',
            'description'   => 'nullable',
            'remise'        => 'required|numeric|min:0|max:100',
            'date_debut'    => 'required|date|before_or_equal:date_fin',
            'date_fin'      => 'required|date|after_or_equal:date_debut'
        ];
    }
}
