<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

use App\Livewire\AuthForm;
// use App\Livewire\AuthRegister;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', AuthForm::class)->name('login');

}); 

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');   
    
    Route::get('/landing', [HomeController::class, 'index'])->name('home');
    

    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::delete('/threads/{thread:slug}', [ThreadController::class, 'destroy'])->name('threads.destroy');
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

    Route::post('/threads/{thread}/reply', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


    Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{username}', [ProfileController::class, 'update'])->name('profile.update');
    
    

    Route::get('/search', [HomeController::class, 'search'])->name('search');
});
