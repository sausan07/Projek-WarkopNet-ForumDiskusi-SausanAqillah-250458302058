@extends('layouts.app')

@section('content')



<x-navbar />


<main class="max-w-3xl mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold font-utama text-center text-[#373737] mb-10 underline underline-offset-8 decoration-[#FFB347] decoration-4">
        Edit Profil
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

    <form action="{{ route('profile.update', $user->username) }}" method="POST" enctype="multipart/form-data" class="bg-[#FFFAF0] shadow-xl rounded-2xl p-8 space-y-6 border border-[#FFB347]/40">
        @csrf
        @method('PUT')
        
       
        <div class="text-center">
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" class="w-32 h-32 rounded-full border-4 border-[#FFB347] mx-auto object-cover" alt="{{ $user->name }}">
            @else
                <div class="w-32 h-32 rounded-full border-4 border-[#FFB347] bg-[#373737] text-white flex items-center justify-center text-5xl font-bold mx-auto">
                    {{ strtoupper(substr($user->username, 0, 2)) }}
                </div>
            @endif
        </div>

       
        <div>
            <label class="block font-semibold text-[#373737] mb-2">Foto Profil</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-[#FFB347]/50 bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] @error('image') border-red-500 @enderror" />
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
        </div>

     

        <div>
            <label class="block font-semibold text-[#373737] mb-2">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl border border-[#FFB347]/50 bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] @error('name') border-red-500 @enderror" required />
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    

        <div>
            <label class="block font-semibold text-[#373737] mb-2">Username</label>
            <input type="text" value="{{ $user->username }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 text-gray-600" disabled />
            <p class="text-sm text-gray-500 mt-1">Username tidak dapat diubah</p>
        </div>


        <div>
            <label class="block font-semibold text-[#373737] mb-2">Email</label>
            <input type="email" value="{{ $user->email }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-100 text-gray-600"  disabled />
            <p class="text-sm text-gray-500 mt-1">Email tidak dapat diubah</p>
        </div>


        <div>
            <label class="block font-semibold text-[#373737] mb-2">Bio</label>
            <textarea
                name="bio" rows="4"
                placeholder="Ceritakan sedikit tentang diri Anda..."
                class="w-full px-4 py-3 rounded-xl border border-[#FFB347] bg-white focus:ring-2 focus:ring-[#FF6EC7] focus:outline-none text-[#373737] resize-none @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Maksimal 200 karakter</p>
        </div>

        
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('profile', $user->username) }}" 
               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-[#373737] rounded-xl font-semibold transition-colors">
                Batal
            </a>
            <button
                type="submit"
                class="px-6 py-3 bg-[#FFB347] hover:bg-[#EB5160] text-white rounded-xl font-semibold transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</main>
@endsection
