<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function index()
    {
        $query = Like::query();

        return response()->json(['success'=> true, 'data' => $query->get()]);
    }


    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'postId' => 'required'
            ]);

            $existingLike = Like::where('postId', $request->postId)->where('userId', $user->id)->first();

            if ($existingLike) {
                $existingLike->delete();
                return response()->json(['success' => true, 'msg' => "Curtida removida"], 200);
            }

            $like = Like::create([
                "postId" => $request->postId,
                "userId" => $user->id
            ]);

            return response()->json(['success' => true, 'msg' => "Curtida aplicada", 'data' => $like], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => "Curtida não aplicada"], 400);
        }
    }


    public function show(int $id)
    {
        try {
            $like = Like::findOrFail($id);
            return response()->json(['success' => true, 'msg' => 'Curtida encontrada.','data' => $like], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Curtida não encontrada', 'data' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Like $like)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
