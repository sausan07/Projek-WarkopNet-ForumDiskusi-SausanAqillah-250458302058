<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use layout;

class AuthForm extends Component
{
    public $activeForm = 'login';

    //login
    public $login_email;
    public $login_password;
    public $remember = false;

    //regis
    public $name;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;

    public function switchTo($form) {
        $this->activeForm = $form;
    }
    

    public function submitLogin() {
        $this->validate([
            'login_email' => 'required|email',
            'login_password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $this->login_email,
            'password' => $this->login_password,
        ], $this->remember)) {
            return redirect()->route('landing');
        }

        $this->addError('login_email', 'Email atau Password salah kak');
    }

    public function submitRegister() {
        $this->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:3|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        return redirect()->route('landing');
    }

    public function render() {
        return view('livewire.auth-form')->layout('layouts.auth');
    }
}
