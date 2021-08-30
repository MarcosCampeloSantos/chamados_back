<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'rel_dep' => 'required',
            'rel_user' => 'required',
            'rel_top' => 'required',
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
            'rel_dep.required' => 'Departamento é Obrigatorio!',
            'rel_user.required' => 'Email é Obrigatorio!',
            'rel_top.required' => 'Email é Obrigatorio!'
        ];
    }
}
