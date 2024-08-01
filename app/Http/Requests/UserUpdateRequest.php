<?php

namespace App\Http\Requests;

use App\Exceptions\UnauthorizedUserActionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = (int) $this->route()->user;
        $authUserId = (int) Auth::user()->id;

        if ($userId !== $authUserId) {
            throw new UnauthorizedUserActionException;
        }
        return [
            'username' => [
                'required',
                'string',
                'max:30',
                'min:5',
                'regex:/^[\w]+$/',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'avatar_url' => 'string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.string' => 'O nome de usuário deve ser uma string.',
            'username.max' => 'O nome de usuário não pode ter mais de 30 caracteres.',
            'username.min' => 'O nome de usuário deve ter pelo menos 5 caracteres.',
            'username.unique' => 'Este usuário já está em uso.',
            'username.regex' => 'O nome de usuário só pode conter letras, números e underlines.',

            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',

            'surname.required' => 'O campo sobrenome é obrigatório.',
            'surname.string' => 'O campo sobrenome deve ser uma string.',
            'surname.max' => 'O campo sobrenome não pode ter mais de 255 caracteres.',

            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'email.max' => 'O campo email não pode ter mais de 255 caracteres.',

            'password.min' => 'A senha deve ter pelo menos 5 caracteres.',

            'avatar_url.string' => 'Avatar deve ser do tipo string.',
        ];
    }
}
