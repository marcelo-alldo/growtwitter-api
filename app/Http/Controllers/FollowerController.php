<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{

    public function index()
    {
        $result = Follower::all();
        return response()->json(['success' => true, 'msg' => "Lista de seguidores total", 'data' => $result], 200);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'followingId' => 'required',
                'followerId' => 'required'
            ]);

            $existingFollow = Follower::where('followingId', $request->followingId)->where('followerId', $request->followerId)->first();

            if ($existingFollow) {
                $existingFollow->delete();
                return response()->json(['success' => true, 'msg' => "Deixou de seguir"], 200);
            }

            $follow = Follower::create([
                "followingId" => $request->followingId,
                "followerId" => $request->followerId
            ]);

            return response()->json(['success' => true, 'msg' => "Seguido com sucesso", 'data' => $follow], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => "Falha"], 422);
        }
    }

    public function show(string $id)
    {
        $osQueEuSigo = Follower::with('follower', 'following')->where('followerId', $id)->count();
        $quemSegueEle = Follower::with('following', 'follower')->where('followingId', $id)->count();
        $osQueEuSigoData = Follower::with('follower', 'following', 'posts')->where('followerId', $id)->get();
        $quemSegueEleData = Follower::with('following', 'follower', 'posts')->where('followingId', $id)->get();

        return response()->json(['success' => true, 'msg' => "Lista de quem eu sigo e me segue", 'followings' => $osQueEuSigo, 'followers' => $quemSegueEle, 'followingsData' => $osQueEuSigoData, 'followersData' => $quemSegueEleData], 200);
    }


}
