<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavbarProfile extends Component
{
    public $open = false;
    public $user;

    public function mount()
    {
        $this->user = Auth::user(); // SIMPAN user sekali saat mount
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }

    public function close()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.navbar-profile');
    }
}
