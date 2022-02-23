<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartamentsRequest extends FormRequest
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
            "branches" => ['required', 'array', 'min:1'],
            "users" => ['nullable', 'array'],
            "token" => ['required', 'string']
        ];
    }


    public function attributes()
    {
        return [
            "name" => "Nombre",
            "branches" => "Centros",
            "users" => "Usuarios",
            "token" => "Token"
        ];
    }
}
