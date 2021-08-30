<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'cria_dep' => 'required',
            'cria_dep_email' => 'required',
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
            'cria_dep.required' => 'Nome do Departamento é Obrigatorio!',
            'cria_dep_email.required' => 'Email é Obrigatorio!',
        ];
    }
}
