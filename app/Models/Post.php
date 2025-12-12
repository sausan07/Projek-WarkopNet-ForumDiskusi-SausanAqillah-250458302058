<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{

    protected $fillable = ['content', 'user_id', 'thread_id', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function likesCount(){
        return $this->likes()->count();
    }

    public function isLikedBy(User $user = null) {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isBookmarkedBy(User $user = null) {
        if (!$user) return false;
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
}
