<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'cria_top' => 'required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cria_top.required' => 'Campo Topico Obrigatorio!'
        ];
    }
}
