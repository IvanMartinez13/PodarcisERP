<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('store Vigilancia Ambiental');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'code' => ['required', 'string', 'max:8'],
            'state' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'direction' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
        ];
    }


    public function attributes()
    {
        return [
            'title' => __('forms.title'),
            'description' =>  __('forms.description'),
            'starts_at' =>  __('forms.starts_at'),
            'code' =>  __('forms.code'),
            'state' =>  __('forms.state'),
            'location' =>  __('forms.location'),
            'direction' =>  __('forms.direction'),
            'image' => __('forms.image'),
        ];
    }
}
