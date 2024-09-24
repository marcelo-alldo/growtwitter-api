<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user:id,username,name,avatar_url', 'likes'])
            ->withCount('likes')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $posts]);
    }
    public function store(Request $request)
    {
        try {

            $user = Auth::user();

            $request->validate(
                [
                    'content' => 'required'
                ],
                [
                    'required' => 'O campo :attribute é obrigatório.'
                ]
            );

            $post = Post::create([
                "userId" => $user->id,
                "content" => $request->content
            ]);

            return response()->json(['success' => true, 'msg' => 'Post cadastrado com sucesso!', 'data' => $post], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 422);
        }
    }
    public function show()
    { {
            try {
                $userId = auth()->user()->id;
                $posts = Post::where('userId', $userId)->with(['user', 'likes'])->withCount('likes')->get();

                return response()->json(['success' => true, 'data' => $posts]);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
            }
        }
    }
    public function update(Request $request, string $id)
    {
        try {

            $post = Post::findOrFail($id);

            $request->validate(
                [
                    'content' => 'required'
                ],
                [
                    'required' => 'Faltou :attribute'
                ]
            );

            $post->content = $request->content;
            $post->save();
            return response()->json(['success' => true, 'msg' => 'Post editado com sucesso!', 'data' => $post]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }
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
