<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request) {

        $threadsQuery = Thread::with(['user', 'category', 'posts']);

        if ($request->has('category')) {

            $categorySlug = $request->category;

            //filter thread dr kategori
            $threadsQuery->whereHas('category', function($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $threads = $threadsQuery->latest()->paginate(10);

        $categories = Category::withCount('threads')->get();

        //rekomen user
        $suggestedUsers = User::where('id', '!=', Auth::user()->id)
            ->where('user_role', 'member')             
            ->withCount('followers')                   
            ->orderBy('followers_count', 'desc')       // paling banyak followers
            ->limit(7)                                
            ->get();

        //ambil kategori 
        $selectedCategory = $request->category;

        return view('home', compact('threads', 'categories', 'suggestedUsers', 'selectedCategory'));
    }

    //search
    public function search(Request $request) {

        $searchQuery = $request->input('t');

        //berdasarkan judul atau isi konten
        $threads = Thread::with(['user', 'category', 'posts'])
            ->where(function($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('content', 'like', '%' . $searchQuery . '%');
            })
            ->latest()            
            ->paginate(10);      

        //ambil kategori dn jumlah thread
        $categories = Category::withCount('threads')->get();

        $suggestedUsers = User::where('id', '!=', Auth::user()->id)
            ->where('user_role', 'member')
            ->withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->limit(7)
            ->get();


        return view('home', compact('threads','categories','suggestedUsers','searchQuery'));
    }
}
