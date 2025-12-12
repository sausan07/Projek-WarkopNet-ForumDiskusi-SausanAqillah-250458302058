

<div class="flex flex-col md:flex-row max-w-4xl w-full bg-white shadow-2xl rounded-2xl overflow-hidden">


<div class="hidden md:block md:w-1/2 
    {{ $activeForm === 'login' ? 'md:order-1' : 'md:order-2' }}">

    @if($activeForm === 'login')
        <img src="{{ asset('images/login.png') }}" class="w-full h-full object-cover">
    @else
        <img src="{{ asset('images/regis.png') }}" class="w-full h-full object-cover">
    @endif=

</div>



  <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center 
  {{ $activeForm === 'login' ? 'md:order-2' : 'md:order-1' }}">


    @if($activeForm === 'login')

      <h2 class="text-gray-900 mb-8 text-3xl">Silahkan Login Kak</h2>

      <form wire:submit.prevent="submitLogin" class="space-y-6">

        <div>
          <input wire:model="login_email" type="email" placeholder="Email" 
          class="w-full p-3 rounded-full border border-gray-900 focus:ring-2 
          focus:ring-gray-900 @error('login_email') border-red-500 @enderror"> 
          @error('login_email') <p class="text-red-500 text-xs mt-1">
            {{ $message }}</p> @enderror
        </div>

        <div>
          <input wire:model="login_password" type="password" placeholder="Password" 
          class="w-full p-3 rounded-full border border-gray-900 focus:ring-2 
          focus:ring-gray-900 @error('login_password') border-red-500 @enderror">
          @error('login_password') <p class="text-red-500 text-xs mt-1">
            {{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between items-center text-sm">
          <label><input type="checkbox" wire:model="remember" class="mr-2">
            Remember me</label>
        </div>

        <button type="submit" class="w-full bg-[#F0A04B] text-gray-900 p-3 rounded-full 
        font-semibold hover:bg-[#FCE7C8]">Login</button>

        <p class="text-center text-sm pt-4">Kakak Belum punya akun?
          <button type="button" wire:click="switchTo('register')" 
          class="font-semibold hover:underline">
            Ayok Daftar sekarang!
          </button>
        </p>

      </form>
    @endif

  
    @if($activeForm === 'register')
      <h2 class="text-gray-900 mb-8 text-3xl">Silahkan Mendaftar Kak</h2>

      <form wire:submit.prevent="submitRegister" class="space-y-6">

        <input wire:model="name" type="text" placeholder="Nama Lengkap" 
        class="w-full p-3 rounded-full border border-gray-900 
        @error('name') border-red-500 @enderror">
        @error('name') <p class="text-red-500 text-xs mt-1">
          {{ $message }}</p> @enderror

        <input wire:model="username" type="text" placeholder="Username" 
        class="w-full p-3 rounded-full border border-gray-900 
        @error('username') border-red-500 @enderror">
        @error('username') <p class="text-red-500 text-xs mt-1">
          {{ $message }}</p> @enderror

        <input wire:model="email" type="email" placeholder="Email" 
        class="w-full p-3 rounded-full border border-gray-900 
        @error('email') border-red-500 @enderror">
        @error('email') <p class="text-red-500 text-xs mt-1">
          {{ $message }}</p> @enderror

        <input wire:model="password" type="password" placeholder="Buat Password" 
        class="w-full p-3 rounded-full border border-gray-900 
        @error('password') border-red-500 @enderror">
        @error('password') <p class="text-red-500 text-xs mt-1">
          {{ $message }}</p> @enderror

        <input wire:model="password_confirmation" type="password" 
        placeholder="Konfirmasi Password" class="w-full p-3 rounded-full 
        border border-gray-900">

        <button class="w-full bg-[#F0A04B] text-gray-900 p-3 rounded-full 
        font-semibold hover:bg-[#FCE7C8]">Daftar</button>

        <p class="text-center text-sm pt-4">Kakak Sudah punya Akun?
          <button type="button" wire:click="switchTo('login')" 
          class="font-semibold hover:underline">
            Masuk di sini Kak
          </button>
        </p>

      </form>
    @endif

  </div>
</div>
