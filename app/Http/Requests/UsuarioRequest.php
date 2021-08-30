<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'nivel' => 'required',
            'departamento' => 'required',
            'email' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Campo Nome é Obrigatorio!',
            'nivel.required' => 'Por favor escolher nivel de acesso!',
            'departamento.required' => 'O Campo Departamento é Obrigatorio!',
            'email.required' => 'O Campo E-mail é obrigatorio!',
            'password.required' => 'O Campo senha é Obrigatorio!',
            'password.min' => 'A senha deve ter no minimo :min caracteres!',
            'password_confirmation.required' => 'O Campo de Confirmação de Senha é Obrigatorio!',
            'password.confirmed' => 'As senhas não correspondem'
        ];
    }
}
