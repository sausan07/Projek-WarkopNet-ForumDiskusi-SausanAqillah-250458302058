@extends('layouts.app')

@section('content')

<x-navbar />


<main class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">


    <aside class="md:col-span-1 space-y-6">
        <div class="bg-white border border-[#FFB347]/40 rounded-2xl shadow p-5">
            <h2 class="font-utama text-lg font-bold mb-4">Teman Nongkrong</h2>
            <div class="space-y-4">
                @forelse($suggestedUsers as $user)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('profile', $user->username) }}" class="font-semibold hover:text-[#EB5160]">
                                {{ $user->name }}
                            </a>
                            <p class="text-sm text-gray-500">&#64;{{ $user->username }}</p>
                        </div>
                    </div>
                    @livewire('follow-button', ['userId' => $user->id], key('follow-'.$user->id))
                </div>
                @empty
                <p class="text-sm text-gray-500">Belum ada pengguna yang disarankan</p>
                @endforelse
            </div>
        </div>
    </aside>


    <section class="md:col-span-2 space-y-8">

     
<div class="bg-white border border-[#FFB347]/50 rounded-2xl shadow p-6 space-y-4">
        <!-- Pencarian -->
        <div class="relative w-full">
            <form action="{{ route('search') }}" method="GET">
                <input  
                    type="text" 
                    name="t" 
                    value="{{ $searchQuery ?? '' }}" 
                    placeholder="Cari diskusi..." 
                    class="w-full rounded-full border border-[#FFB347]/60 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#EB5160]"
                />
                <button type="submit" class="absolute right-4 top-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 hover:text-[#EB5160] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Kategori di bawah pencarian -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('home') }}" class="px-4 py-1.5 text-sm rounded-full font-semibold transition {{ !request('category') ? 'bg-[#F29F05] text-white' : 'bg-[#FFF8F0] border border-[#FFB347] hover:bg-[#F29F05] hover:text-white' }}">
                Semua
            </a>
            @if($categories->count() > 0)
                @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) }}" class="px-4 py-1.5 text-sm rounded-full font-semibold transition {{ request('category') == $category->slug ? 'bg-[#F29F05] text-white' : 'bg-[#FFF8F0] border border-[#FFB347] hover:bg-[#F29F05] hover:text-white' }}"> 
                    {{ $category->name }} 
                </a>
                @endforeach
            @endif
        </div>
    </div>

 
        @if(isset($searchQuery) && $searchQuery)
            <div class="flex items-center justify-between">
                <h1 class="font-utama text-2xl font-bold text-[#373737]">  Hasil Pencarian: <span class="text-[#EB5160]">"{{ $searchQuery }}"</span>
                </h1>
                <a href="{{ route('home') }}" class="text-[#0509f2] hover:underline">Kembali</a>
            </div>
        @else
            <h1 class="font-utama text-2xl font-bold text-[#373737]">Diskusi Terbaru</h1>
        @endif

       
        @forelse($threads as $thread)
        <article class="bg-white border border-[#FFB347]/50 rounded-2xl shadow p-6 hover:shadow-md transition">
            
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold">
                    @if($thread->user->image)
                        <img src="{{ asset('storage/' . $thread->user->image) }}" 
                            class="w-10 h-10 rounded-full object-cover border shadow-sm" />
                    @else
                        <div class="w-10 h-10 rounded-full bg-black
                                    text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ strtoupper(substr($thread->user->username, 0, 2)) }}
                        </div>
                        
                    @endif
                </div>
                <div class="flex-1">
<div class="flex items-center gap-2">
    <h3 class="font-semibold">
        {{ $thread->user->username }}
    </h3>

    <span class="text-xs text-gray-500">
        • {{ $thread->created_at->diffForHumans() }}
    </span>

    <span class="text-xs bg-[#FFB347]/20 text-[#F29F05] px-3 py-1 rounded-full ml-auto">
        #{{ $thread->category->name }}
    </span>
</div>

                    <a href="{{ route('threads.show', $thread->slug) }}">
                        <h2 class="mt-2 text-xl font-utama font-bold text-[#373737] hover:text-[#EB5160] transition">
                            {{ $thread->title }}
                        </h2>
                    </a>

                    
<p class="text-[#555] mb-4 line-clamp-2">
    {{ Str::limit(strip_tags($thread->content), 150) }}
</p>

                    
              
                    <div class="mt-4 flex items-center gap-6 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            {{ $thread->posts->count() }} Balasan
                        </span>
                        <a href="{{ route('threads.show', $thread->slug) }}" class="text-[#EB5160] hover:underline font-semibold">
                            Lihat Diskusi →
                        </a>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="bg-white border border-[#FFB347]/50 rounded-2xl shadow p-12 text-center">
            @if(isset($searchQuery) && $searchQuery)
                <p class="text-gray-500 text-lg">Tidak ada hasil untuk "{{ $searchQuery }}"</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 bg-[#FFB347] hover:bg-[#EB5160] text-white px-6 py-3 rounded-xl font-semibold transition">
                    ← Kembali ke Beranda
                </a>
            @else
                <p class="text-gray-500 text-lg">Belum ada diskusi. Mulai diskusi pertama Anda!</p>


                <a href="{{ route('threads.create') }}" class="inline-block mt-4 bg-[#FFB347] hover:bg-[#EB5160] text-white px-6 py-3 rounded-xl font-semibold transition">
                    Buat Diskusi Baru
                </a>
            @endif
        </div>
        @endforelse

      
        <div class="mt-8">
            {{ $threads->links() }}
        </div>

    </section>

</main>
@endsection