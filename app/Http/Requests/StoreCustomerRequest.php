<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;

class StoreCustomerRequest extends FormRequest
{

    protected $redirectRoute = 'customers.create';

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

            //DATOS DEL USUARIO
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

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

            //DATOS DEL USUARIO
            'name' => 'Nombre',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Contraseña',
        ];
    }
}
