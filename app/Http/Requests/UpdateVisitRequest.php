<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateVisitRequest extends FormRequest
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
            "name" => ['required', 'string', 'max:255'],
            "description" => ['required', 'string'],
            "starts_at" => ['required', 'date'],
            "ends_at" => ['required', 'date'],
            "color" => ['required', 'string', 'max:255'],
            "token" => ['required', 'string'],
            "users" => ['nullable', 'array'],
        ];
    }

    public function attributes()
    {
        return [
            "name" => __('forms.name'),
            "description" =>  __('forms.description'),
            "starts_at" => __('forms.starts_at'),
            "ends_at" => __('forms.ends_at'),
            "color" => __('forms.color'),
            "token" => "Token",
            "users" => __('forms.users'),
        ];
    }
}
