<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('store Tareas');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:255"],
            "color" => ["required", "string", "max:255"],
            "image" => ["nullable", "image "],
        ];
    }

    public function attributes()
    {
        return [
            "name" => "Nombre",
            "description" => "Descripción",
            "color" => "Color",
            "image" => "Imagen",
        ];
    }
}
