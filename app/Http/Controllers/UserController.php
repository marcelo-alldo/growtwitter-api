<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('posts')->findOrFail(auth()->user()->id);
        return response()->json(['success' => 'true', 'msg' => 'Usuário autenticado', 'data' => $user]);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            $token = $user->createToken($user->email)->plainTextToken;


            return response()->json([
                'success' => 'true',
                'msg' => 'Usuário cadastrado com sucesso',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()], 500);
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

    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            $request->validated();
            $user = User::findOrFail($id);

            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('surname')) {
                $user->surname = $request->surname;
            }
            if ($request->has('username')) {
                $user->username = $request->username;
            }
            if ($request->has('avatar_url')) {
                $user->avatar_url = $request->avatar_url;
            }

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
