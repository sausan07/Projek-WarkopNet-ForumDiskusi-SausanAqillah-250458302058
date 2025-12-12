<?php

namespace App\Livewire;

use App\Models\Bookmark;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookmarkButton extends Component
{
    public $threadId = null;
    public $postId = null;
    public $isBookmarked = false;

    public function mount($threadId = null, $postId = null) {
        $this->threadId = $threadId;
        $this->postId = $postId;
        $this->checkBookmarkStatus();
    }


    

    public function checkBookmarkStatus() {
        if (Auth::check()) {
            $query = Bookmark::where('user_id', Auth::id());
            
            if ($this->threadId) {
                $query->where('thread_id', $this->threadId);
            }
            
            if ($this->postId) {
                $query->where('post_id', $this->postId);
            }
            
            $this->isBookmarked = $query->exists();
        }
    }

    public function toggleBookmark() {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isBookmarked) {
            
            $query = Bookmark::where('user_id', Auth::id());
            
            if ($this->threadId) {
                $query->where('thread_id', $this->threadId);
            }
            
            if ($this->postId) {
                $query->where('post_id', $this->postId);
            }
            
            $query->delete();
            $this->isBookmarked = false;


        } 
        
        else {
           
            Bookmark::create([
                'user_id' => Auth::id(),
                'thread_id' => $this->threadId,
                'post_id' => $this->postId,
            ]);

            $this->isBookmarked = true;
            
        }
        
    }
    

    public function render() {
        return view('livewire.bookmark-button');
    }
}
