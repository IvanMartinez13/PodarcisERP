<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('customer-manager');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //DATOS DEL USUARIO
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'position' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }


    public function attributes()
    {
        return [
            //DATOS DEL USUARIO
            'name' => 'Nombre',
            'username' => 'Username',
            'email' => 'Email',
            'position' => 'Cargo',
            'password' => 'Contraseña',

        ];
    }
}
