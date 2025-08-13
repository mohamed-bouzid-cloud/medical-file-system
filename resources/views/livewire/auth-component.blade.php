<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800 px-4 py-12">
  <div class="w-full max-w-2xl bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-700 backdrop-blur-lg">
    <!-- Glowing header bar -->
    <div class="relative h-2 bg-gradient-to-r from-blue-500 to-purple-600">
      <div class="absolute inset-0 bg-blue-500 opacity-30 animate-pulse"></div>
    </div>

    <div class="p-10">
      <!-- Animated title -->
      <div class="mb-10 text-center group">
        <h2 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 inline-block">
          {{ ucfirst($action) }} as {{ ucfirst($role) }}
        </h2>
        <div class="h-1 mt-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full w-20 mx-auto transition-all duration-500 group-hover:w-32"></div>
      </div>

      {{-- LOGIN FORM --}}
      <p>Debug: {{ $email }} / {{ $password }}</p>
     

      @if ($action === 'login')
        <form wire:submit.prevent="login" class="space-y-6">
          <div class="relative">
            <input
              type="email"
              wire:model="email"
              placeholder=" "
              autocomplete="email"
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('email') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            @if($login_error)
    <div class="p-4 bg-red-600 text-white rounded mb-4">
        {{ $login_error }}
    </div>
@endif

            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Email Address
            </label>
            @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="relative">
            <input
              type="password"
              wire:model="password"
              placeholder=" "
              autocomplete="current-password"
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('password') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Password
            </label>
            @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <button
            type="submit"
            class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 rounded-xl font-bold text-white shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1"
          >
            <span class="drop-shadow-md">Login</span>
            <span class="ml-2">→</span>
          </button>
        </form>
      @endif

      {{-- SIGNUP FORM --}}
      @if ($action === 'signup')
        <form wire:submit.prevent="register" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Full Name --}}
          <div class="relative col-span-2">
            <input
              type="text"
              wire:model.defer="full_name"
              placeholder=" "
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('full_name') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Full Name
            </label>
            @error('full_name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div class="relative">
            <input
              type="email"
              wire:model.defer="email"
              placeholder=" "
              autocomplete="email"
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('email') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Email Address
            </label>
            @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Password --}}
          <div class="relative">
            <input
              type="password"
              wire:model.defer="password"
              placeholder=" "
              autocomplete="new-password"
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('password') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Password
            </label>
            @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Confirm Password --}}
          <div class="relative">
            <input
              type="password"
              wire:model.defer="confirm_password"
              placeholder=" "
              autocomplete="new-password"
              class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                @error('confirm_password') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
            />
            <label
              class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
              peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
            >
              Confirm Password
            </label>
            @error('confirm_password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Patient fields --}}
          @if ($role === 'patient')
            <div class="relative">
              <input
                type="text"
                wire:model.defer="ipp"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('ipp') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                IPP
              </label>
              @error('ipp')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <input
                type="date"
                wire:model.defer="dob"
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('dob') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Date of Birth
              </label>
              @error('dob')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <select
                wire:model.defer="gender"
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer appearance-none
                  @error('gender') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              >
                <option value=""></option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Gender
              </label>
              <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                ▼
              </div>
              @error('gender')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <input
                type="text"
                wire:model.defer="phone"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('phone') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Phone Number
              </label>
              @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative col-span-2">
              <input
                type="text"
                wire:model.defer="address"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('address') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Address (optional)
              </label>
              @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          @endif

          {{-- Doctor fields --}}
          @if ($role === 'doctor')
            <div class="relative">
              <input
                type="text"
                wire:model.defer="specialization"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('specialization') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Specialization
              </label>
              @error('specialization')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <input
                type="text"
                wire:model.defer="license_number"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('license_number') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Medical License
              </label>
              @error('license_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <input
                type="number"
                wire:model.defer="experience"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('experience') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Years of Experience
              </label>
              @error('experience')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative">
              <input
                type="text"
                wire:model.defer="phone"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('phone') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Phone Number
              </label>
              @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="relative col-span-2">
              <input
                type="text"
                wire:model.defer="clinic_address"
                placeholder=" "
                class="w-full px-5 py-4 bg-gray-800 border-2 rounded-xl focus:outline-none peer
                  @error('clinic_address') border-red-500 focus:ring-2 focus:ring-red-500 @else border-gray-700 focus:ring-2 focus:ring-blue-500/30 @enderror"
              />
              <label
                class="absolute left-4 top-1/2 -translate-y-1/2 px-1 bg-gray-800 text-gray-400 pointer-events-none
                peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-focus:top-0 peer-focus:text-sm peer-focus:text-blue-400 transition-all duration-300"
              >
                Clinic Address (optional)
              </label>
              @error('clinic_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          @endif

          <button
            type="submit"
            class="col-span-2 w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 rounded-xl font-bold text-white shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1 mt-4"
          >
            <span class="drop-shadow-md">Create Account</span>
            <span class="ml-2">→</span>
          </button>
        </form>
      @endif
    </div>

    {{-- Feedback messages --}}
    @if(session()->has('error'))
      <div class="px-10 pb-6">
        <div class="p-4 bg-red-900/50 border border-red-700 rounded-xl text-red-300 font-medium text-center animate-pulse">
          {{ session('error') }}
        </div>
      </div>
    @endif

    @if(session()->has('success'))
      <div class="px-10 pb-6">
        <div class="p-4 bg-green-900/50 border border-green-700 rounded-xl text-green-300 font-medium text-center animate-pulse">
          {{ session('success') }}
        </div>
      </div>
    @endif
  </div>
</div>
