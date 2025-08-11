<div class="max-w-md mx-auto mt-10 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-xl shadow-2xl overflow-hidden p-8 backdrop-blur-sm">
    <!-- Form Header -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-primary-400">
                <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-secondary-400 mb-2">Patient Portal</h2>
        <p class="text-gray-400">Access your medical records securely</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-900/50 border border-red-700 rounded-lg text-red-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2 flex-shrink-0">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <!-- Email -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
            <div class="relative">
                <input type="email" wire:model="email" 
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-gray-500"
                       placeholder="your@email.com">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
            <div class="relative">
                <input type="password" wire:model="password" 
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-gray-500"
                       placeholder="••••••••">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-500">
                        <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="mt-2 text-right">
                <a href="/forgot-password" class="text-sm text-primary-400 hover:text-primary-300 transition-colors">Forgot password?</a>
            </div>
        </div>

        <button type="submit"
                class="w-full py-3 px-6 bg-gradient-to-r from-primary-600 to-secondary-500 hover:from-primary-500 hover:to-secondary-400 text-white font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 focus:ring-offset-gray-900">
            Access Medical Records
        </button>

        <div class="mt-6 text-center text-sm text-gray-400">
            Don't have an account? 
            <a href="/register" class="text-primary-400 hover:text-primary-300 font-medium transition-colors">Register here</a>
        </div>
    </form>
</div>
