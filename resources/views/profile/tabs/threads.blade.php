<div>
    <h2 class="text-2xl font-bold text-[#373737] mb-6">
        Diskusi oleh {{ $user->name }}
    </h2>

<div class="space-y-4">
@forelse($user->threads as $thread)
    <article class="bg-[#FFFAF0] p-5 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
        <div class="flex items-start justify-between mb-3">

            <div class="flex-1">
                <a href="{{ route('threads.show', $thread->slug) }}" class="text-lg font-bold text-[#373737] hover:text-[#EB5160]">
                    {{ $thread->title }}
                </a>
                <span class="text-xs text-[#555] block mt-1">
                    {{ $thread->created_at->diffForHumans() }} • #{{ $thread->category?->name ?? 'Tanpa Kategori' }}
                </span>
            </div>

            {{-- Tombol hapus hanya muncul jika ini profil pemilik yg login --}}
            @if(auth()->check() && auth()->id() === $user->id)
                <form id="delete-thread-{{ $thread->slug }}"
      action="{{ route('threads.destroy', $thread->slug) }}"
      method="POST">
    @csrf
    @method('DELETE')

    <button type="button"
            onclick="confirmDelete('delete-thread-{{ $thread->slug }}')"
            class="text-red-600 hover:text-red-800">
        Hapus
    </button>
</form>

            @endif

        </div>

        <p class="text-[#555] mb-4 line-clamp-2">
            {{ Str::limit(strip_tags($thread->content), 150) }}
        </p>

        <div class="flex gap-4 items-center text-[#555] text-sm">
            <span>💬 {{ $thread->posts->count() }} Balasan</span>
        </div>
    </article>
@empty
    <p class="text-center text-gray-500 py-8">Belum ada diskusi yang dibuat.</p>
@endforelse

</div>


</div>
