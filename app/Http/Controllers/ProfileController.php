<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function show($username){
        $user = User::where('username', $username)->firstOrFail();
        
        $user->load([
            'threads' => fn($t) => $t->latest()->take(10),
            'posts' => fn($t) => $t->latest()->take(10),
            'followers',
            'following',
            'bookmarks.thread',
            'bookmarks.post.thread',
            'reports.thread',
            'reports.post.thread'
        ]);

        return view('profile.show', compact('user'));
    }

    public function edit($username) {
        $user = User::where('username', $username)->firstOrFail();
        
        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, $username) {
        $user = User::where('username', $username)->firstOrFail();
        
        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            
            $path = $request->file('image')->store('avatars', 'public');
            $validated['image'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile', $user->username);
    }
}
