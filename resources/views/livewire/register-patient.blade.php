<div class="min-h-screen bg-black flex items-center justify-center p-4">
  <div class="w-full max-w-4xl"> <!-- Increased max-width to 4xl -->
    <form wire:submit.prevent="register" class="bg-transparent space-y-8">
      <!-- Form header -->
      <div class="text-center">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-white">
            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">Patient Registration</h1>
        <p class="text-lg text-gray-300 mt-2">Secure access to your medical records</p>
      </div>

      <!-- Form body -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left column -->
        <div class="space-y-6">
          <!-- IPP Field -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Patient ID (IPP) <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="text" 
                wire:model="ipp" 
                placeholder="Enter unique patient ID" 
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 text-white transition-all"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            @error('ipp')
              <p class="mt-2 text-sm text-red-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Email Field -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Email Address <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="email" 
                wire:model="email" 
                placeholder="your@email.com" 
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 text-white transition-all"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                  <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
              </div>
            </div>
            @error('email')
              <p class="mt-2 text-sm text-red-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Right column -->
        <div class="space-y-6">
          <!-- Password Field -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="password" 
                wire:model="password" 
                placeholder="••••••••" 
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 text-white transition-all"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            @error('password')
              <p class="mt-2 text-sm text-red-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Confirm Password Field -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Confirm Password <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="password" 
                wire:model="password_confirmation" 
                placeholder="••••••••" 
                class="w-full px-5 py-4 bg-black border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500 text-white transition-all"
              />
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Terms and Submit -->
      <div class="space-y-6">
        <!-- Terms and Conditions -->
        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input 
              id="terms" 
              type="checkbox" 
              class="w-5 h-5 text-blue-600 border-gray-600 rounded focus:ring-blue-500 bg-gray-800"
            >
          </div>
          <label for="terms" class="ml-3 text-sm text-gray-300">
            I agree to the <a href="#" class="text-blue-400 hover:text-blue-300 underline">Terms</a> and <a href="#" class="text-blue-400 hover:text-blue-300 underline">Privacy Policy</a>
          </label>
        </div>

        <!-- Submit button -->
        <div>
          <button type="submit"
            class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-colors text-lg">
            Create Account
          </button>
        </div>

        <!-- Footer link -->
        <div class="text-center pt-2">
          <p class="text-gray-400">
            Already have an account? 
            <a href="/login" class="text-blue-400 hover:text-blue-300 font-medium underline">Sign in</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>