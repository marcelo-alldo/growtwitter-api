<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('posts')->findOrFail(auth()->user()->id);
        return response()->json(['success' => 'true', 'msg' => 'Usuário autenticado', 'data' => $user]);
    }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'username' => ['required', 'string', 'max:30', 'min:5', 'unique:users', 'regex:/^[\w]+$/'],
                'email' => 'required|email|unique:users',
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'password' => ['required', 'min:6', 'max:225', 'regex:/^[A-Za-z0-9@!\-_#]+$/'],
                'avatar_url' => 'string|nullable',
            ], [
                'username.required' => 'O campo nome de usuário é obrigatório.',
                'username.string' => 'O nome de usuário só pode conter letras',
                'username.max' => 'O nome de usuário não pode ter mais de 30 caracteres.',
                'username.min' => 'O nome de usuário deve ter pelo menos 5 caracteres.',
                'username.unique' => 'Este usuário já está em uso.',
                'username.regex' => 'O nome de usuário só pode conter letras, números e underlines.',

                'name.required' => 'O campo nome é obrigatório.',
                'name.string' => 'O campo nome deve conter apenas letras.',
                'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',

                'surname.required' => 'O campo sobrenome é obrigatório.',
                'surname.string' => 'O campo sobrenome deve ser uma string.',
                'surname.max' => 'O campo sobrenome não pode ter mais de 255 caracteres.',

                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.unique' => 'Este email já está em uso.',
                'email.max' => 'O campo email não pode ter mais de 255 caracteres.',

                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 7 caracteres.',
                'password.regex' => 'Sua senha deve ter algum dos caracteres especiais "#, -, !, _, @" ',

                'avatar_url.string' => 'Avatar deve ser do tipo string.',
            ]);

            $user = User::create($data);
            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json([
                'success' => 'true',
                'msg' => 'Usuário cadastrado com sucesso',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()], 422);
        }
    }

    public function show(string $id)
    {
        try {
            return response()->json(['success' => 'true', 'msg' => 'Usuário encontrado com sucesso', 'data' => User::with('posts')->findOrFail($id)]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'surname' => 'nullable|string|max:255',
                'username' => ['nullable', 'string', 'max:30', 'min:5', 'regex:/^[\w]+$/',  Rule::unique('users')->ignore($id)],
                'avatar_url' => 'string|nullable',
            ], [

                'username.string' => 'O nome de usuário deve ser uma string.',
                'username.max' => 'O nome de usuário não pode ter mais de 30 caracteres.',
                'username.min' => 'O nome de usuário deve ter pelo menos 5 caracteres.',
                'username.unique' => 'Este usuário já está em uso.',
                'username.regex' => 'O nome de usuário só pode conter letras, números e underlines.',


                'name.string' => 'O campo nome deve ser uma string.',
                'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',


                'surname.string' => 'O campo sobrenome deve ser uma string.',
                'surname.max' => 'O campo sobrenome não pode ter mais de 255 caracteres.',

                'avatar_url.string' => 'Avatar deve ser do tipo string.',
            ]);

            $user = User::findOrFail($id);

            if ($request->has('avatar_url')) {
                $user->avatar_url = $request->avatar_url;
            }

            $user->fill([
                'name' => $request->name,
                'surname' => $request->surname,
                'username' => $request->username,
            ]);

            $user->save();

            return response()->json(['success' => 'true', 'msg' => 'Usuário alterado com sucesso', 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['success' => 'true', 'msg' => 'Usuário deletado com sucesso', 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }
}
