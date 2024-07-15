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
            'avatar' => 'nullable|file|max:30|extensions:jpeg,jpg,png',
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
            'name.max' => 'The name may not be greater than 255 characters.',

            'surname.required' => 'The last name field is required.',
            'surname.string' => 'The last name must be a string.',
            'surname.max' => 'The surname may not be greater than 255 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.max' => 'The email may not be greater than 255 characters.',

            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 5 characters.',

            'avatar.max' => 'The avatar must not be larger than 30kb (kilobytes).',
            'avatar.extensions' => 'The avatar must be a file of type: jpeg, jpg, png.',
        ];
    }
}
