@extends('layouts.app')

@section('content')

<x-navbar />


<main class="max-w-4xl mx-auto py-10 px-6">

    <!-- Thread Card -->
    <article class="bg-white border border-[#FFB347]/50 rounded-3xl shadow-lg p-8 mb-10 transition hover:shadow-xl">
        <div class="flex items-start gap-5">
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
                <div>
                    <h3 class="font-semibold text-[#EB5160] text-lg">
                        <a href="{{ route('profile', $thread->user->username) }}" class="hover:underline">
                            {{ $thread->user->username }}
                        </a>
                    </h3>

                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-gray-500">
                            {{ $thread->created_at->diffForHumans() }}
                        </span>

                        <span class="text-xs bg-[#FFB347]/20 text-[#F29F05] px-3 py-1 rounded-full font-semibold">
                            #{{ $thread->category->name }}
                        </span>
                    </div>

                    
                </div>

                <h1 class="mt-3 text-2xl font-utama font-bold text-[#373737]">{{ $thread->title }}</h1>
                <p class="mt-3 text-[#373737]/90 leading-relaxed whitespace-pre-line">{!! $thread->content !!}</p>
                <div class="flex flex-wrap items-center gap-4 mt-6 text-sm text-[#373737]/70">
                    <span class="flex items-center gap-1.5 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#F29F05]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        {{ $thread->posts->count() }} Balasan
                    </span>
                    @livewire('bookmark-button', ['threadId' => $thread->id], key('bookmark-thread-'.$thread->id))
                    @auth
                        @livewire('report-button', ['threadId' => $thread->id], key('report-thread-'.$thread->id))
                    @endauth
                    @livewire('share-thread', ['threadUrl' => url()->current()], key('share-thread-'.$thread->id))
                </div>
            </div>
        </div>
    </article>





    
    <!-- Reply Form -->
<section class="bg-[#FFFAF0] border border-[#FFB347]/40 rounded-2xl p-6 mb-8 shadow">
    <h2 class="font-bold font-utama text-lg mb-3 text-[#373737]">Balas Diskusi</h2>
    <form action="{{ route('posts.store', $thread->slug) }}" method="POST">
        @csrf
        <textarea name="content" id="summernote">{{ old('content') }}</textarea>
        @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        <div class="flex justify-end gap-3 mt-5">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-xl text-[#373737] font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-[#F29F05] hover:bg-[#EB5160] text-white rounded-xl font-bold transition">Kirim Balasan</button>
        </div>
    </form>
</section>




    <!-- Replies List -->
    <section class="space-y-6">
        <h3 class="font-bold text-[#373737] font-utama text-xl mb-5">
            {{ $thread->posts->count() }} Balasan
        </h3>
        @forelse($thread->posts as $post)
        <div class="flex items-start gap-4 group">
        @if($post->user->image)
            <img src="{{ asset('storage/' . $post->user->image) }}" 
                class="w-9 h-9 rounded-full object-cover border shadow-sm" />
        @else
            <div class="w-9 h-9 rounded-full bg-black
                        text-white flex items-center justify-center font-bold text-sm shadow-sm">
                {{ strtoupper(substr($post->user->username, 0, 2)) }}
            </div>
        @endif

            <div class="border rounded-2xl p-5 shadow bg-white border-[#FFB347]/40 flex-1 group-hover:shadow-lg transition">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <a href="{{ route('profile', $post->user->username) }}" class="font-semibold text-[#EB5160] hover:underline">
                            {{ $post->user->username }}
                        </a>
                        <span class="text-xs text-gray-500 ml-2">
                            • {{ $post->created_at ? $post->created_at->diffForHumans() : 'Tanggal tidak tersedia' }}
                        </span>
                    </div>
                </div>
                <p class="mt-1 text-[#373737] leading-relaxed whitespace-pre-line">{!! $post->content !!}</p>
                <div class="flex items-center gap-4 mt-4 text-sm">
                    @livewire('like-button', ['postId' => $post->id], key('like-'.$post->id))
                    @livewire('bookmark-button', ['postId' => $post->id], key('bookmark-'.$post->id))
                    @livewire('report-button', ['postId' => $post->id], key('report-post-'.$post->id))
                    
                    
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada balasan. Jadilah yang pertama!</p>
        </div>
        @endforelse
    </section>

</main>



<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>