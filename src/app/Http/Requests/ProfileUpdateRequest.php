<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'telefono' => ['string', 'max:20'], // Add validation rules for telefono
            'direccion.calle' => ['string', 'max:255'], // Add validation rules for direccion.calle
            'direccion.ciudad' => ['string', 'max:255'], // Add validation rules for direccion.ciudad
            'direccion.estado' => ['string', 'max:255'], // Add validation rules for direccion.estado
            'direccion.codigo_postal' => ['string', 'max:20'], // Add validation rules for direccion.codigo_postal
        ];
    }
}
