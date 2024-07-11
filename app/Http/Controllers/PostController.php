<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        return response()->json(['success' => true, 'data' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate([
                'content' => 'required'
            ],
            [
                'required' => 'O campo :attribute é obrigatório.'
            ]);

            $post = Post::create([
                "userId" => $user->id,
                "content" => $request->content
            ]);

            return response()->json(['success' => true, 'msg' => 'Post cadastrado com sucesso!', 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => true, 'msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        {
            try {

                $post = Post::findOrFail($id);

                return response()->json(['success' => true, 'data' => $post]);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $post = Post::findOrFail($id);

            $request->validate([
                'content' => 'required'
            ],
            [
                'required' => 'Faltou :attribute'
            ]);

            $post->content = $request->content;
            $post->save();
            return response()->json(['success' => true, 'msg' => 'Post editado com sucesso!', 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $post = Post::findOrFail($id);

            $post->delete();
            return response()->json(['success' => true, 'msg' => 'Post nº ' . $id . ' excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }
}
