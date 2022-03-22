<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return Auth::user()->can('update Vigilancia Ambiental');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'required', 'max:255'],
            'type' => ['string', 'required', 'max:255'],
            'group' => ['string', 'required', 'max:255'],
            'file' => ['nullable'],
            'token' => ['string', 'required'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'type' => 'Tipo',
            'group' => 'Grupo',
            'file' => 'Documento',
            'token' => 'Token',
        ];
    }
}
