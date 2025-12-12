<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'username', 'email', 'user_role', 'bio', 'image','password',];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
    }
 
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->username)->exists();
    }

    public function isAdmin()
    {
        return $this->user_role === 'admin';
    }

    // flmn
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    //nyoba


    public function badge()
    {
        return cache()->remember("user_badge_{$this->id}", 60, function () {

            $threads = $this->threads()->count();
            $posts   = $this->posts()->count();

            // hitung like dari semua post user
            $postIds = $this->posts()->pluck('id');
            $likes = \App\Models\Like::whereIn('post_id', $postIds)->count();

            $points = ($threads * 3) + ($posts * 1) + ($likes * 2);

            if ($points > 30) return ['Legenda Meja 3', '⭐'];
            if ($points > 20) return ['Barista Diskusi', '🍵'];
            if ($points > 10) return ['Anak Warkop', '🔥'];
            if ($points > 5)  return ['Pelanggan Tetap', '🍪'];

            return ['Kopi Hitam', '☕'];
        });
    }

}
