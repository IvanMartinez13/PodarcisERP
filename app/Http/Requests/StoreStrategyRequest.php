<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStrategyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('store Ods');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ['required', 'string', 'max:255'],
            "description"  => ['required', 'string', 'max:255'],
            "performances"  => ['required', 'string'],
            "indicator"  => ['required', 'string', 'max:255'],
            "increase" => ['required', 'numeric'],
            "target" => ['required', 'numeric'],
            "base_year" => ['required', 'numeric'],
            "target_year" => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            "title" => "Título",
            "description"  => "Descripción",
            "performances"  => "Actuaciones",
            "indicator"  => "Indicador",
            'increase' => 'Incremento | Reducción',
            'target' => 'Objetivo',
            'base_year' => 'Año de referencia',
            'target_year' => 'Año del objetivo',

        ];
    }
}
