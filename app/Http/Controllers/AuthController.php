<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function index() {}


    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['success' => false, 'msg' => 'Verificar email ou senha.'], 401);
            }

            $user->tokens()->delete();
            $token = $user->createToken($user->email)->plainTextToken;

            return response()->json(['success' => true, 'msg' => "Login efetuado com sucesso", 'data' => [
                'user' => $user,
                'token' => $token
            ]], 200);
        } catch (\Throwable $th) {
            Log::error('Erro ao fazer login', ['error' => $th->getMessage()]);
            return response()->json(['success' => false, 'msg' => "Erro ao logar"], 400);
        }
    }


    public function show(string $token)
    {
        try {
            $authToken = DB::table("personal_access_tokens")->where('token', $token)->first();
            if ($authToken) {
                return true;
            }

            return false;
        } catch (\Throwable $e) {
            return response()->json(["msg" => "Falha ao realizar a operação de validação de token", "error" => $e->getMessage()]);
        }
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['success' => true, 'msg' => "Logout feito com sucesso"], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }
}
