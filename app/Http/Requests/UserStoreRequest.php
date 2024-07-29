<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:100|min:5|unique:users|alpha_num:ascii',
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'password' => 'required|min:5|max:255',
            'avatar_url' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.string' => 'O nome de usuário deve ser uma string.',
            'username.max' => 'O nome de usuário não pode ter mais de 100 caracteres.',
            'username.min' => 'O nome de usuário deve ter pelo menos 5 caracteres.',
            'username.unique' => 'Este usuário já está em uso.',
            'username.alpha_num' => 'O nome de usuário só pode conter letras e números.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',

            'surname.required' => 'O campo sobrenome é obrigatório.',
            'surname.string' => 'O campo sobrenome deve ser uma string.',
            'surname.max' => 'O campo sobrenome não pode ter mais de 255 caracteres.',

            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'email.max' => 'O campo email não pode ter mais de 255 caracteres.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 5 caracteres.',

            'avatar_url.max' => 'O avatar não deve ter mais de 8mb (megabytes).',
            'avatar_url.extensions' => 'O avatar deve ser um arquivo do tipo: jpeg, jpg, png.',
        ];
    }
}
