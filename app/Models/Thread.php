<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{

    protected $fillable = ['title', 'content', 'slug', 'user_id', 'category_id'];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    protected static function boot() {
    parent::boot();
        
    static::creating(function ($thread) {
        if (empty($thread->slug)) {
            $thread->slug = Str::slug($thread->title) . '-' . Str::random(3);
            }
        });
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function postsCount() {
        return $this->posts()->where('status', 'active')->count();
    }
}
