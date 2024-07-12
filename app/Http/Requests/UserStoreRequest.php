<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'string|required|max:100|min:5|unique:users',
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'required|min:5',
            'avatar' => [
                File::types(['jpeg', 'jpg', 'png'])
                    ->max(30),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'The username field is required.',
            'username.string' => 'The username must be a string.',
            'username.max' => 'The username may not be greater than 100 characters.',
            'username.min' => 'The username must be at least 5 characters.',
            'username.unique' => 'The username has already been taken.',

            'name.required' => 'The first name field is required.',
            'name.string' => 'The first name must be a string.',

            'surname.required' => 'The last name field is required.',
            'surname.string' => 'The last name must be a string.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',

            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 5 characters.',

            'avatar.file' => 'The avatar must be a file.',
            'avatar.size' => 'The avatar must not be larger than 30 kilobytes.',
            'avatar.extensions' => 'The avatar must be a file of type: jpeg, jpg, png.',
        ];
    }
}
