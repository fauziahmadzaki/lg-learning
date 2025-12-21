<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Masuk</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    <div class="min-h-screen flex">
        
        <!-- Left Side: Branding / Image (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-orange-600 overflow-hidden items-center justify-center">
            <!-- Background Pattern/Image -->
            <div class="absolute inset-0 bg-cover bg-center opacity-20 mix-blend-multiply" 
                 style="background-image: url('https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=1000&auto=format&fit=crop')">
            </div>
            
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600 to-yellow-600 opacity-90"></div>

            <!-- Content -->
            <div class="relative z-10 p-12 text-center text-white max-w-lg">
                <div class="mb-8 flex justify-center">
                    <!-- Logo Placeholder (Optional) -->
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <h2 class="text-4xl font-extrabold mb-6">{{ config('app.name') }}</h2>
                <p class="text-lg text-orange-50 font-medium leading-relaxed">
                    Platform pembelajaran terpadu untuk masa depan yang lebih cerah. Kelola jadwal, akses materi, dan pantau perkembangan siswa dalam satu tempat.
                </p>
                
                <!-- Decorative Blobs -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-yellow-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-red-500 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white relative">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-orange-600 tracking-tight">{{ config('app.name') }}</h2>
                    <p class="text-sm text-gray-500 mt-2">Login ke Portal Siswa/Admin</p>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900">Selamat Datang! 👋</h2>
                    <p class="mt-2 text-sm text-gray-500">Masukkan kredensial Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" autofocus
                                class="appearance-none block w-full px-4 py-3.5 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent sm:text-sm transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password with Show Toggle -->
                    <div x-data="{ show: false }">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        </div>
                        <div class="mt-2 relative rounded-md shadow-sm">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                                class="appearance-none block w-full px-4 py-3.5 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent sm:text-sm transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white pr-12"
                                placeholder="••••••••">
                            
                            <!-- Toggle Button -->
                            <button type="button" @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600 transition focus:outline-none">
                                <!-- Eye Icon (Show) -->
                                <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Slash Icon (Hide) -->
                                <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded transition duration-150 ease-in-out cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">Ingat saya</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-semibold text-orange-600 hover:text-orange-500 transition">
                                    Lupa Password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-orange-200 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:scale-[1.02] transition-all duration-200">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-10">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Atau kembali ke</span>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <a href="/" class="text-sm font-medium text-gray-600 hover:text-orange-600 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
