<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'postId');
    }

    public function retweets()
    {
        return $this->hasMany(Retweet::class, 'postId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId')->with('user');
    }
}
