<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->hasRole('customer-manager') || auth()->user()->hasRole('super-admin')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ['required', 'string', 'max:255'],
            "location" => ['required', 'string', 'max:255'],
            "coordinates" => ['required', 'string', 'max:255'],
            "users" => ['nullable', 'array'],
            "token" => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [

            "name" => "Nombre",
            "location" => "Dirección",
            "coordinates" => "Coordenadas",
            "users" => "Usuarios",
            "token" => "Token",
        ];
    }
}
