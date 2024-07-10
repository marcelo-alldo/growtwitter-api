<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name',
        'document',
        'city',
        'received',
    ];

    protected $table = 'people';

    public function scopeReceived($query, $received) {
        return $query->where('received', $received);
    }
}
