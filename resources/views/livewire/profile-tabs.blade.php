<section class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex border-b border-[#FFB347]/40 mb-6 overflow-x-auto">

        {{-- THREADS --}}
        <button wire:click="setTab('threads')"
            class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
            {{ $activeTab === 'threads' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
            📝 Diskusi ({{ $user->threads->count() }})
        </button>

        {{-- POSTS --}}
        <button wire:click="setTab('posts')"
            class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
            {{ $activeTab === 'posts' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
            💬 Balasan ({{ $user->posts->count() }})
        </button>

        {{-- BOOKMARKS --}}
        @if(auth()->check() && auth()->id() === $user->id)
        <button wire:click="setTab('bookmarks')"
            class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
            {{ $activeTab === 'bookmarks' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
            🔖 Bookmark ({{ $user->bookmarks->count() }})
        </button>
        @endif

        {{-- REPORTS (hanya muncul untuk pemilik akun) --}}
        @if(auth()->check() && auth()->id() === $user->id)
        <button wire:click="setTab('reports')"
            class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
            {{ $activeTab === 'reports' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
            🚩 Laporan ({{ $user->reports->count() }})
        </button>
        @endif


        {{-- FOLLOWING --}}
<button wire:click="setTab('following')"
    class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
    {{ $activeTab === 'following' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
    👣 Mengikuti ({{ $user->following->count() }})
</button>

{{-- FOLLOWERS --}}
<button wire:click="setTab('followers')"
    class="px-6 py-3 font-bold border-b-2 whitespace-nowrap
    {{ $activeTab === 'followers' ? 'border-[#FFB347] text-[#373737]' : 'border-transparent text-gray-500' }}">
    👥 Pengikut ({{ $user->followers->count() }})
</button>


    </div>

    {{-- KONTEN TAB --}}
    @if($activeTab === 'threads')
        @include('profile.tabs.threads')
    @endif

    @if($activeTab === 'posts')
        @include('profile.tabs.posts')
    @endif

    @if($activeTab === 'bookmarks')
        @include('profile.tabs.bookmarks')
    @endif

    @if($activeTab === 'reports')
        @include('profile.tabs.reports')
    @endif

    @if($activeTab === 'following')
    @include('profile.tabs.following')
@endif

@if($activeTab === 'followers')
    @include('profile.tabs.followers')
@endif


</section>
