@extends('layouts.app')

@section('content')

<x-navbar />


<main class="max-w-4xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold font-utama text-center text-[#373737] mb-10 underline underline-offset-8 decoration-[#FFB347] decoration-4">
        Buat Diskusi Baru
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('threads.store') }}" method="POST" class="bg-[#FFFAF0] shadow-xl rounded-2xl p-8 space-y-6 border border-[#FFB347]/40">
        @csrf
        
    
        <div>
            <label class="block font-semibold text-[#373737] mb-2">Judul Diskusi *</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Tulis judul yang menarik..." class="w-full px-4 py-3 rounded-xl border border-[#FFB347]/50 bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] @error('title') border-red-500 @enderror" required />
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <label class="  text-[#373737] mb-2">Kategori *</label>
            <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-[#FFB347]/50 bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] @error('category_id') border-red-500 @enderror" required>
                <option value="" disabled selected>Pilih kategori...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>



        <div>
            <label class="block font-semibold text-[#373737] mb-2">Isi Diskusi *</label>
            <textarea id="editor" name="content" rows="8" placeholder="Ceritakan pemikiran atau pertanyaan Anda..." 
    class="w-full px-4 py-3 rounded-xl border border-[#FFB347]/50 bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] resize-none @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>

            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter</p>
        </div>


        
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('home') }}" 
               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-[#373737] rounded-xl font-semibold transition-colors">
                Batal
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-[#FFB347] hover:bg-[#EB5160] text-white rounded-xl font-semibold transition-colors">
                Posting Diskusi
            </button>
        </div>
    </form>
</main>



<script>
    CKEDITOR.replace('editor', {
        height: 200,
        allowedContent: true,
        versionCheck: false,

        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
            { name: 'paragraph',    items: ['NumberedList', 'BulletedList'] },
            { name: 'links',        items: ['Link'] }
        ]
    });
</script>

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


@endsection
