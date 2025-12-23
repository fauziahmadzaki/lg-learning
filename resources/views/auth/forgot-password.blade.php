@php
    $siteSettingsLogo = \App\Models\SiteSetting::get('site_logo');
    $siteLogoUrl = $siteSettingsLogo ? asset('storage/' . $siteSettingsLogo) : asset('img/image.png');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ $siteLogoUrl }}">
    <title>{{ config('app.name', 'Laravel') }} - Lupa Password</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    <div class="min-h-screen flex">
        
        <!-- Left Side: Branding (Hidden on mobile) -->
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
                   <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm shadow-xl">
                        <img src="{{ $siteLogoUrl }}" alt="Logo" class="w-16 h-16 object-contain">
                    </div>
                </div>
                <h2 class="text-4xl font-extrabold mb-6">Lupa Kata Sandi?</h2>
                <p class="text-lg text-orange-50 font-medium leading-relaxed">
                    Jangan khawatir, hal ini biasa terjadi. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>
                
                 <!-- Decorative Blobs -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-yellow-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-red-500 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white relative">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-10">
                    <img src="{{ $siteLogoUrl }}" alt="Logo" class="w-16 h-16 object-contain mx-auto mb-4">
                    <h2 class="text-2xl font-extrabold text-orange-600 tracking-tight">{{ config('app.name') }}</h2>
                    <p class="text-sm text-gray-500 mt-2">Reset Password</p>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900">Reset Password 🔒</h2>
                    <p class="mt-2 text-sm text-gray-500">Masukkan email yang terdaftar pada akun Anda.</p>
                </div>

                <!-- Session Status -->
                <x-ui.auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                         <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" autofocus
                                class="appearance-none block w-full px-4 py-3.5 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent sm:text-sm transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                placeholder="nama@email.com">
                        </div>
                        <x-inputs.error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-orange-200 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform hover:scale-[1.02] transition-all duration-200">
                            Kirim Tautan Reset
                        </button>
                    </div>
                </form>

                <div class="mt-10">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Sudah ingat password?</span>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm font-between text-gray-600 hover:text-orange-600 transition flex items-center justify-center gap-2 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Halaman Login
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
