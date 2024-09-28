<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'postId' => 'required',
                'content' => 'required'
            ]);

            $comment = Comment::create([
                "postId" => $request->postId,
                "userId" => $user->id,
                "content" => $request->content
            ]);

            return response()->json(['success' => true, 'msg' => "Comentário aplicado!", 'data' => $comment], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $comment = Comment::findOrFail($id);

            $request->validate(
                [
                    'content' => 'required'
                ],
                [
                    'required' => 'Faltou :attribute'
                ]
            );
            $comment->content = $request->content;
            $comment->save();

            return response()->json(['success' => true, 'msg' => 'Comentário editado.', 'data' => $comment], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return response()->json(['success' => true, 'msg' => "Comentário excluído!"]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()]);
        }
    }
}
