<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Like::query();

        return response()->json(['success'=> true, 'data' => $query->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'postId' => 'required'
            ]);

            if (Like::where('postId', $request->postId)->where('userId', $user->id)->first()) {
                return response()->json(['success' => false, 'msg' => 'Curtida já realizada.'], 400);
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

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $like = Like::findOrFail($id);
            return response()->json(['success' => true, 'msg' => 'Curtida encontrada.','data' => $like], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Curtida não encontrada', 'data' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $like = Like::findOrFail($id);

            $like->delete();

            return response()->json(['success' => true, 'msg' => "Curtida deletada com sucesso"], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => "Curtida não deletada"], 404);
        }
    }
}
