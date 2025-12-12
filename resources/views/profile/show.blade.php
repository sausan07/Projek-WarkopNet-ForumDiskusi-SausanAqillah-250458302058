@extends('layouts.app')

@section('content')

<x-navbar />


<section class="py-12">
    <div class="max-w-4xl mx-auto bg-[#FFFAF0] rounded-2xl shadow-xl p-8 border border-[#FFB347]/40">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" class="w-28 h-28 rounded-full border-4 border-[#FFB347] object-cover" alt="{{ $user->name }}">
            @else
                <div class="w-28 h-28 rounded-full border-4 border-[#FFB347] bg-[#373737] text-white flex items-center justify-center text-4xl font-bold">
                    {{ strtoupper(substr($user->username, 0, 2)) }}
                </div>
            @endif

            <div class="flex-1 text-center sm:text-left">
                @php
    [$badgeName, $badgeIcon] = $user->badge();
@endphp

<h1 class="text-3xl font-bold text-[#373737] flex items-center gap-2 justify-center sm:justify-start">
    {{ $user->name }}

    <span class="text-sm bg-yellow-100 text-gray-700 px-2 py-1 rounded-full flex items-center gap-1">
        {{ $badgeIcon }}
        <span class="hidden sm:inline">{{ $badgeName }}</span>
    </span>
</h1>

                <p class="text-[#555] mt-1 font-accent">&#64;{{ $user->username }}</p>
                @if($user->bio)
                    <p class="text-[#555] mt-2 font-accent">{{ $user->bio }}</p>
                @endif


                
                <div class="flex flex-wrap justify-center sm:justify-start gap-6 mt-4 text-[#373737]">
    @livewire('profile-stats', ['userId' => $user->id], key('profilestats-'.$user->id))
</div>





                <div class="mt-4 flex gap-3 justify-center sm:justify-start">
                    @if(auth()->check() && auth()->id() === $user->id)
                      
                        <a href="{{ route('profile.edit', $user->username) }}" 
                           class="px-6 py-2 rounded-xl bg-[#FFB347] hover:bg-[#FF6EC7] text-white font-bold transition-all duration-300">
                            ✏️ Edit Profil
                        </a>
                    @else
                    

                        @livewire('follow-button', ['userId' => $user->id], key('follow-profile-'.$user->id))
                    @endif

                    
                </div>
            </div>
        </div>
    </div>
</section>


@livewire('profile-tabs', ['user' => $user])



@endsection
