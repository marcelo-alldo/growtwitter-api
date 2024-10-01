<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\Retweet;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(string $id)
    {
        try {
            $user = User::with('posts')->findOrFail($id);

            $osQueEuSigo = Follower::where('followerId', $id)->count();
            $quemSegueEle = Follower::where('followingId', $id)->count();

            $osQueEuSigoData = Follower::with('follower', 'following', 'posts')->where('followerId', $id)->get();
            $quemSegueEleData = Follower::with('following', 'follower', 'posts')->where('followingId', $id)->get();

            $posts = Post::with([
                'user:id,username,name,avatar_url',
                'likes',
                'retweets',
                'comments' => function ($query) {
                    $query->with('user');
                }
            ])
                ->withCount('likes', 'comments')
                ->latest()
                ->get();



            $retweets = Retweet::with(['user', 'post'])->latest()->get();


            return response()->json([
                'success' => true,
                'msg' => 'Usuário encontrado com sucesso',
                'data' => [
                    'user' => $user,
                    'followings' => $osQueEuSigo,
                    'followers' => $quemSegueEle,
                    'followingsData' => $osQueEuSigoData,
                    'followersData' => $quemSegueEleData,
                    'posts' => $posts,
                    'retweets' => $retweets
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }

}
