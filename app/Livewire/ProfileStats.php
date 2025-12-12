<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ProfileStats extends Component
{
    public $userId;

    public $followers;
    public $following;
    public $threads;
    public $posts;

    protected $listeners = ['followUpdated' => 'refreshStats'];

    public function refreshStats()
    {
        $user = User::find($this->userId);

        $this->followers = $user->followers()->count();
        $this->following = $user->following()->count();
        $this->threads = $user->threads()->count();
        $this->posts = $user->posts()->count();
    }

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->refreshStats();
    }

    public function render()
    {
        return view('livewire.profile-stats');
    }
}
