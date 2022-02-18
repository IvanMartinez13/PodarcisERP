<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('super-admin');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "token" => ["required", "string"],
            "name" => ["required", "string", "max:255"],
            "icon" => ["nullable", "image"],
        ];
    }

    public function attributes()
    {
        return [
            "token" => "Token",
            "name" => "Nombre",
            "icon" => "Icono",
        ];
    }
}
