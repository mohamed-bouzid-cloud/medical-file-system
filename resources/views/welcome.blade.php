<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MediVault | Secure Medical Records</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            primary: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            },
            secondary: {
              400: '#818cf8',
              500: '#6366f1',
              600: '#4f46e5',
            }
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'float-reverse': 'float-reverse 5s ease-in-out infinite',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(-20px)' },
            },
            'float-reverse': {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%': { transform: 'translateY(20px)' },
            }
          }
        }
      }
    }
  </script>
  <style>
    

    .gradient-bg {
      background: radial-gradient(ellipse at bottom, #1B2735 0%, #090A0F 100%);
    }
    .card-gradient {
      background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    }
    .hero-gradient {
      background: linear-gradient(135deg, rgba(14,165,233,0.15) 0%, rgba(99,102,241,0.15) 100%);
    }
  </style>
</head>
<div class="min-h-screen flex flex-col justify-between bg-gradient-to-b from-black to-blue-800 text-white">


  <!-- Animated background elements -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-primary-500 opacity-10 blur-3xl animate-float"></div>
    <div class="absolute top-2/3 right-1/3 w-80 h-80 rounded-full bg-secondary-500 opacity-10 blur-3xl animate-float-reverse"></div>
  </div>

  <!-- Navigation -->
  <nav class="relative z-10 py-6 px-6 md:px-12 flex justify-between items-center">
    <div class="flex items-center space-x-2">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-primary-400">
        <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
      </svg>
      <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-secondary-400">MediVault</span>
    </div>
    <div class="hidden md:flex items-center space-x-8">
      <a href="#" class="text-gray-300 hover:text-white transition-colors">Features</a>
      <a href="#" class="text-gray-300 hover:text-white transition-colors">Security</a>
      <a href="#" class="text-gray-300 hover:text-white transition-colors">Pricing</a>
      <a href="#" class="text-gray-300 hover:text-white transition-colors">About</a>
    </div>
    <div class="flex items-center space-x-4">
      <a href="/login" class="px-4 py-2 text-sm font-medium text-primary-100 hover:text-white transition-colors">Sign In</a>
      <a href="/register" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-primary-600 to-secondary-500 text-sm font-semibold text-white shadow-lg hover:shadow-xl transition-all hover:opacity-90">Get Started</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 pt-16 pb-32">
    <div class="flex flex-col lg:flex-row items-center">
      <div class="lg:w-1/2 mb-16 lg:mb-0">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-secondary-400">Secure</span> 
          Medical Records <br>for the Modern Age
        </h1>
        <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-lg">
          Your complete health history, encrypted and accessible anywhere. Join thousands of patients managing their care with confidence.
        </p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
          <a href="/register" class="px-8 py-4 rounded-full bg-gradient-to-r from-primary-600 to-secondary-500 text-lg font-semibold text-white shadow-lg hover:shadow-xl transition-all hover:opacity-90 text-center">
            Start Free Trial
          </a>
          <a href="#" class="px-8 py-4 rounded-full border border-gray-700 text-lg font-medium text-gray-200 hover:bg-gray-800/30 transition-colors text-center flex items-center justify-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
            </svg>
            <span>Watch Demo</span>
          </a>
        </div>
        <div class="mt-10 flex items-center space-x-4">
          <div class="flex -space-x-2">
            <img class="w-10 h-10 rounded-full border-2 border-gray-800" src="https://randomuser.me/api/portraits/women/12.jpg" alt="">
            <img class="w-10 h-10 rounded-full border-2 border-gray-800" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
            <img class="w-10 h-10 rounded-full border-2 border-gray-800" src="https://randomuser.me/api/portraits/women/45.jpg" alt="">
          </div>
          <div class="text-sm text-gray-400">
            Trusted by <span class="font-semibold text-white">10,000+</span> patients
          </div>
        </div>
      </div>
      <div class="lg:w-1/2 lg:pl-16">
        <div class="relative">
          <div class="hero-gradient rounded-3xl p-1.5 backdrop-blur-lg">
            <div class="bg-gray-900/80 rounded-2xl overflow-hidden border border-gray-800">
              <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Medical dashboard" class="w-full h-auto">
            </div>
          </div>
          <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-2xl shadow-2xl -z-10 animate-float"></div>
          <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-secondary-500 to-primary-500 rounded-2xl shadow-2xl -z-10 animate-float-reverse"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Trust Badges -->
  <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-8 mb-16">
    <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-8 backdrop-blur-sm">
      <p class="text-center text-gray-400 mb-6 text-sm font-medium uppercase tracking-wider">Trusted by leading healthcare providers</p>
      <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
        <div class="text-gray-400 hover:text-white transition-colors">
          <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L8 4l4 4 4-4zM4 8l4 4 4-4-4-4zm8 8l4 4 4-4-4-4zm4-12l4 4-4 4-4-4z"/>
          </svg>
        </div>
        <div class="text-gray-400 hover:text-white transition-colors">
          <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L2 12l10 12 10-12z"/>
          </svg>
        </div>
        <div class="text-gray-400 hover:text-white transition-colors">
          <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L0 12l12 12 12-12z"/>
          </svg>
        </div>
        <div class="text-gray-400 hover:text-white transition-colors">
          <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L0 6l12 6 12-6z"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <section class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-20">
    <div class="text-center mb-20">
      <span class="inline-block px-4 py-1.5 rounded-full bg-primary-900/50 text-primary-400 text-sm font-medium mb-4">Why Choose Us</span>
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Healthcare <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-secondary-400">Reimagined</span></h2>
      <p class="max-w-2xl mx-auto text-lg text-gray-400">We've built the most secure and intuitive platform for managing your medical records.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">Military-Grade Encryption</h3>
        <p class="text-gray-400">Your data is protected with AES-256 encryption, the same standard used by governments and financial institutions.</p>
      </div>

      <!-- Feature 2 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path d="M18.75 12.75h1.5a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5zM12 6a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 6zM12 18a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 18zM3.75 6.75h1.5a.75.75 0 100-1.5h-1.5a.75.75 0 000 1.5zM5.25 18.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5zM3 12a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 013 12zM9 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zM12.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0zM9 15.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">Unified Health Profile</h3>
        <p class="text-gray-400">Aggregate records from multiple providers into one comprehensive timeline of your health journey.</p>
      </div>

      <!-- Feature 3 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">24/7 Emergency Access</h3>
        <p class="text-gray-400">Critical health information available instantly to emergency responders when you need it most.</p>
      </div>

      <!-- Feature 4 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">Family Sharing</h3>
        <p class="text-gray-400">Securely share records with family members or caregivers with customizable permission levels.</p>
      </div>

      <!-- Feature 5 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 01.75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 019.75 22.5a.75.75 0 01-.75-.75v-4.131A15.838 15.838 0 016.382 15H2.25a.75.75 0 01-.75-.75 6.75 6.75 0 017.815-6.666zM15 6.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" clip-rule="evenodd" />
            <path d="M5.26 17.242a.75.75 0 10-.897-1.203 5.243 5.243 0 00-2.05 5.022.75.75 0 00.625.627 5.243 5.243 0 005.022-2.051.75.75 0 10-1.202-.897 3.744 3.744 0 01-3.008 1.51c0-1.23.592-2.323 1.51-3.008z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">AI Health Insights</h3>
        <p class="text-gray-400">Our algorithms analyze your data to provide personalized health recommendations and trends.</p>
      </div>

      <!-- Feature 6 -->
      <div class="card-gradient rounded-2xl p-8 border border-gray-800 hover:border-primary-500/30 transition-all group">
        <div class="w-14 h-14 rounded-xl bg-primary-900/50 flex items-center justify-center mb-6 group-hover:bg-primary-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-primary-400">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.902 7.098a3.75 3.75 0 013.903-.884.75.75 0 10.498-1.415A5.25 5.25 0 008.005 9.75H7.5a.75.75 0 000 1.5h.054a5.281 5.281 0 000 1.5H7.5a.75.75 0 000 1.5h.505a5.25 5.25 0 006.494 2.701.75.75 0 00-.498-1.415 3.75 3.75 0 01-4.252-1.286h3.001a.75.75 0 000-1.5H9.075a3.77 3.77 0 010-1.5h3.675a.75.75 0 000-1.5h-3c.105-.14.221-.274.348-.402z" clip-rule="evenodd" />
          </svg>
        </div>
        <h3 class="text-xl font-bold mb-3">HIPAA Compliant</h3>
        <p class="text-gray-400">Fully compliant with healthcare privacy regulations in all 50 states and internationally.</p>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 py-20">
    <div class="hero-gradient rounded-3xl p-1 backdrop-blur-lg">
      <div class="bg-gray-900/80 rounded-2xl p-12 text-center border border-gray-800">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to take control of your health records?</h2>
        <p class="max-w-2xl mx-auto text-lg text-gray-400 mb-8">Join thousands of patients who trust MediVault with their most sensitive information.</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
          <a href="/register" class="px-8 py-4 rounded-full bg-gradient-to-r from-primary-600 to-secondary-500 text-lg font-semibold text-white shadow-lg hover:shadow-xl transition-all hover:opacity-90">
            Get Started - It's Free
          </a>
          <a href="#" class="px-8 py-4 rounded-full border border-gray-700 text-lg font-medium text-gray-200 hover:bg-gray-800/30 transition-colors">
            Schedule a Demo
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="relative z-10 border-t border-gray-800/50 mt-20 py-12 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-center mb-12">
        <div class="flex items-center space-x-2 mb-6 md:mb-0">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-primary-400">
            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
          </svg>
          <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-400 to-secondary-400">MediVault</span>
        </div>
        <div class="flex flex-wrap justify-center gap-8 md:gap-12">
          <div>
            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Product</h4>
            <ul class="space-y-3">
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Features</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Pricing</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Security</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Integrations</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Company</h4>
            <ul class="space-y-3">
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">About</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Careers</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Press</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Contact</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Resources</h4>
            <ul class="space-y-3">
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Blog</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Help Center</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Privacy</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Terms</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Connect</h4>
            <ul class="space-y-3">
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Twitter</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">LinkedIn</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Facebook</a></li>
              <li><a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">Instagram</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="pt-8 mt-8 border-t border-gray-800/50 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy; {{ date('Y') }} MediVault. All rights reserved.</p>
        <div class="flex space-x-6">
          <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-primary-400 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>