<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'followingId',
        'followerId'
    ];

    public function following() // esse cara aqui tá sendo seguido
    {
        return $this->belongsTo(User::class, 'followingId', 'id')->with(['retweets.user', 'retweets.post']);
    }

    public function follower() // esse cara aqui tá seguindo
    {
        return $this->belongsTo(User::class, 'followerId', 'id')->with(['retweets.user', 'retweets.post']);
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'userId', 'followingId')->with(['likes', 'retweets', 'user'])->withCount('likes');
    }

}
