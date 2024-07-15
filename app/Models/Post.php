<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
}
