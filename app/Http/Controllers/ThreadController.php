<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function create() {
        //ambil semua data kategori
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
        ]);

        $thread = Thread::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(), //id user login
            'slug' => Str::slug($validated['title']) . '-' . Str::random(6),
        ]);

        return redirect()->route('threads.show', $thread->slug);
    }

public function destroy(Thread $thread)
{

    $thread->delete();

    return redirect()->route('profile', Auth::user()->username);
}



    public function show(Thread $thread) { 
            $thread->load([
                'user', 
                'category', 
                'posts' => function($query) {
                    $query->with(['user', 'likes']);
                }
            ]);
            
            return view('threads.show', compact('thread'));   
        
    }
}
