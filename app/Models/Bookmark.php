<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{

    public $timestamps = false;
    
    protected $fillable = ['user_id', 'thread_id', 'post_id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
