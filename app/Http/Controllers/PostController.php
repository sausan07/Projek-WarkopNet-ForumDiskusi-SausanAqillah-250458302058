<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request, Thread $thread){
        $validated = $request->validate([
            'content' => 'required|string|min:3',
        ]); 

        $post = Post::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'thread_id' => $thread->id,
            'status' => 'active',
        ]);

        return redirect()->route('threads.show', $thread->slug);
    }

    public function destroy(Post $post)
{
    // pastikan hanya pemilik komentar yg bisa hapus
    if (Auth::id() !== $post->user_id) {
        abort(403, 'Unauthorized action.');
    }

    $threadSlug = $post->thread->slug; // simpan slug sebelum delete

    $post->delete();

    // balik ke halaman thread setelah hapus
    return redirect()->route('profile', Auth::user()->username);
}

}
