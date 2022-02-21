<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //DATOS EXCLUSIVOS DEL CLIENTE
            "company" => ["required", "string", "max:255"],
            "nif" => ["required", "string", "max:255"],
            "location" => ["required", "string", "max:255"],
            "contact" => ["required", "string", "max:255"],
            "contact_mail" => ["required", "email", "max:255"],
            "phone" => ["required", "string", "max:255"],
            "token" => ["required", "string"],
            "active" => ["nullable", "numeric"],

        ];
    }


    public function attributes()
    {
        return [

            //DATOS EXCLUSIVOS DEL CLIENTE
            "company" => "Empresa",
            "nif" => "Nif",
            "location" => "Dirección",
            "contact" => "Persona de contacto",
            "contact_mail" => "Email de contacto",
            "phone" => "Teléfono",
            "token" => "Token",
            "active" => "Activo",

        ];
    }
}
