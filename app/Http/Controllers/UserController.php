<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('posts')->findOrFail(auth()->user()->id);
        return response()->json(['success' => 'true', 'msg' => 'Usuário autenticado', 'data' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();
            if (isset($data['avatar'])) {
                $avatarName = AvatarService::storeAvatar($data['avatar']);
                $data['avatar_url'] = AvatarService::mountUserAvatarUrl(
                    $request->getSchemeAndHttpHost(),
                    $avatarName
                );
            }

            $user = User::create($data);
            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json([
                'success' => 'true',
                'msg' => 'Usuário cadastrado com sucesso',
                'data' => $user,
                'token' => $token
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            return response()->json(['success' => 'true', 'msg' => 'Usuário encontrado com sucesso', 'data' => User::findOrFail($id)]);
        } catch (\Throwable $th) {

            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $user = User::findOrFail($id);

            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json(['success' => 'true', 'msg' => 'Usuário alterado com sucesso', 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['success' => 'false', 'msg' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
