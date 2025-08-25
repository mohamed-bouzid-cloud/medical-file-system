<div class="min-h-screen bg-black flex items-center justify-center p-4">
  <div class="w-full max-w-4xl"> <!-- max width 4xl like your modern design -->
    <div class="bg-transparent rounded-2xl shadow-2xl overflow-hidden border border-gray-700 backdrop-blur-lg">

      <!-- Header -->
      <div class="text-center mb-10">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-white">
            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">{{ ucfirst($action) }} as {{ ucfirst($role) }}</h1>
        <p class="text-lg text-gray-300 mt-2">Secure access to your account</p>
      </div>

      <!-- Global messages -->
      @if(session()->has('error'))
        <div class="px-4 pb-4">
          <div class="p-4 bg-red-900/50 border border-red-700 rounded-xl text-red-300 font-medium text-center animate-pulse">
            {{ session('error') }}
          </div>
        </div>
      @endif

      @if(session()->has('success'))
        <div class="px-4 pb-4">
          <div class="p-4 bg-green-900/50 border border-green-700 rounded-xl text-green-300 font-medium text-center animate-pulse">
            {{ session('success') }}
          </div>
        </div>
      @endif

      <!-- FORMS -->
      <div class="p-6">

        {{-- LOGIN --}}
        @if ($action === 'login')
          <form wire:submit.prevent="login" class="space-y-6">
            {{-- Login error --}}
            @if ($errors->has('login_error'))
              <div class="flex items-center gap-3 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm font-medium shadow-sm animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 110 14 7 7 0 010-14z"/>
                </svg>
                <span>{{ $errors->first('login_error') }}</span>
              </div>
            @endif

            {{-- Email --}}
            <div class="relative">
              <input type="email" wire:model.lazy="email" placeholder=" " autocomplete="email"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-white peer
                  @error('email') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Email Address
              </label>
              @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="relative">
              <input type="password" wire:model.lazy="password" placeholder=" " autocomplete="current-password"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-white peer
                  @error('password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Password
              </label>
              @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-300">
              Login →
            </button>

            {{-- Forgot --}}
            <p class="mt-4 text-center text-sm text-gray-400">
              <a href="#" wire:click.prevent="$set('action', 'forgot')" class="text-blue-400 hover:underline">
                Forgot Password?
              </a>
            </p>
          </form>
        @endif

        {{-- FORGOT --}}
        @if ($action === 'forgot')
          <form wire:submit.prevent="sendResetLink" class="space-y-6">
            <div class="relative">
              <input type="email" wire:model="email" placeholder=" " autocomplete="email"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 placeholder-gray-500 text-white peer
                  @error('email') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Enter your Email
              </label>
              @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-300">
              Send Reset Link
            </button>

            <p class="mt-4 text-center text-sm text-gray-400">
              <a href="#" wire:click.prevent="$set('action', 'login')" class="text-blue-400 hover:underline">
                Back to login
              </a>
            </p>
          </form>
        @endif

        {{-- RESET --}}
        @if ($action === 'reset')
          <form wire:submit.prevent="resetPassword" class="space-y-6">
            <input type="hidden" wire:model="reset_token">

            {{-- Password --}}
            <div class="relative">
              <input type="password" wire:model="password" placeholder=" "
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                New Password
              </label>
              @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm --}}
            <div class="relative">
              <input type="password" wire:model="confirm_password" placeholder=" "
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('confirm_password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Confirm Password
              </label>
              @error('confirm_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-300">
              Reset Password
            </button>

            <p class="mt-4 text-center text-sm text-gray-400">
              <a href="#" wire:click.prevent="$set('action', 'login')" class="text-blue-400 hover:underline">
                Back to login
              </a>
            </p>
          </form>
        @endif

        {{-- SIGNUP --}}
        @if ($action === 'signup')
          <form wire:submit.prevent="register" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Full Name --}}
            <div class="relative col-span-2">
              <input type="text" wire:model.defer="full_name" placeholder=" "
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('full_name') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Full Name
              </label>
              @error('full_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="relative">
              <input type="email" wire:model.defer="email" placeholder=" " autocomplete="email"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('email') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Email Address
              </label>
              @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="relative">
              <input type="password" wire:model.defer="password" placeholder=" " autocomplete="new-password"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Password
              </label>
              @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="relative">
              <input type="password" wire:model.defer="confirm_password" placeholder=" " autocomplete="new-password"
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                  @error('confirm_password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
              <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                  peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                Confirm Password
              </label>
              @error('confirm_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Patient Fields --}}
            @if ($role === 'patient')
              <div class="relative">
                <input type="text" wire:model.defer="ipp" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('ipp') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  IPP
                </label>
                @error('ipp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>
              <div class="relative">
                <input type="date" wire:model.defer="dob"
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('dob') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Date of Birth
                </label>
                @error('dob') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative">
                <select wire:model.defer="gender" class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer appearance-none
                    @error('gender') border-red-500 focus:ring-2 focus:ring-red-500 @enderror">
                  <option value=""></option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Gender
                </label>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                  ▼
                </div>
                @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative">
                <input type="text" wire:model.defer="phone" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('phone') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Phone Number
                </label>
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative col-span-2">
                <input type="text" wire:model.defer="address" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('address') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Address (optional)
                </label>
                @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>
            @endif

            {{-- Doctor Fields --}}
            @if ($role === 'doctor')
              <div class="relative">
                <input type="text" wire:model.defer="specialization" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('specialization') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Specialization
                </label>
                @error('specialization') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative">
                <input type="password" wire:model.defer="certificate_password" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('certificate_password') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Certificate Password
                </label>
                @error('certificate_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative">
                <input type="number" wire:model.defer="experience" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('experience') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Years of Experience
                </label>
                @error('experience') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative">
                <input type="text" wire:model.defer="phone" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('phone') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Phone Number
                </label>
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="relative col-span-2">
                <input type="text" wire:model.defer="clinic_address" placeholder=" "
                  class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 text-white peer
                    @error('clinic_address') border-red-500 focus:ring-2 focus:ring-red-500 @enderror"/>
                <label class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-black text-gray-400 pointer-events-none
                    peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300">
                  Clinic Address (optional)
                </label>
                @error('clinic_address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
              </div>
            @endif

            {{-- Submit Button --}}
            <button type="submit" class="col-span-2 w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-300 mt-4">
              Create Account →
            </button>

          </form>
        @endif

      </div>
    </div>
  </div>
</div>
