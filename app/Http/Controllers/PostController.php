<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $cacheDuration = 5;

    protected $cacheKey = 'posts_index';

    public function index(Request $request)
    {

        if($request->query('filter') == 'following'){

            $posts = DB::table('posts')
            ->join('followers', 'posts.userId', '=', 'followers.followingId')
            ->where('followers.followerId', $authUserId)
            ->join('users', 'posts.userId', '=', 'users.id')
            ->leftJoin('likes', 'posts.id', '=', 'likes.postId')
            ->select('posts.*', 'users.name as author', 'likes.userId as liked_by')
            ->get();

        return response()->json($posts);


            dd($posts);
        }



        $posts = Cache::remember($this->cacheKey, $this->cacheDuration, function () {
            return Post::with(['user:id,username,name,avatar_url', 'likes'])
                ->withCount('likes')
                ->latest()
                ->get();
        });

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


            Cache::forget($this->cacheKey);

            return response()->json(['success' => true, 'msg' => 'Post cadastrado com sucesso!', 'data' => $post], 201);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 422);
        }
    }

    public function show(int $id)
    {
        try {
            $posts = Post::with(['user:id,username,name,avatar_url', 'likes'])
                ->withCount('likes')
                ->where('userId', $id)
                ->latest()
                ->get();

            return response()->json(['success' => true, 'data' => $posts]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
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


            Cache::forget($this->cacheKey);

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

            Cache::forget($this->cacheKey);

            return response()->json(['success' => true, 'msg' => 'Post nº ' . $id . ' excluído com sucesso!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }
}
