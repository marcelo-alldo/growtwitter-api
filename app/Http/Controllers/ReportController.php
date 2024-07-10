<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function user()
    {
        $posts = Post::select('userId', DB::raw('count(userId) as totalPosts'))
            ->groupBy('userId')
            ->orderBy('totalPosts', 'desc')
            ->limit(10)
            ->get();

        $users_id = $posts->map(function($post){
            return $post->userId;
        });

        $users = User::whereIn('id', $users_id)->get();

        $usersWithPosts = $users->map(function($user) use ($posts) {
            $postObj = $posts->filter(function($post) use ($user){
                return $post->userId === $user->id;
            });

            $user->total_posts = array_values($postObj->toArray())[0]['totalPosts'];
            return $user;
        });

        $orderData = collect($usersWithPosts)->sortByDesc('totalPosts')->toArray();

        return response()->json([
            'report_users' => [...$orderData]
        ]);
    }
}
