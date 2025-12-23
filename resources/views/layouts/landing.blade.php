<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ $settings['site_description'] ?? 'L-G Learning - Bimbingan Belajar Terbaik untuk SD, SMP, dan SMA. Metode personal, tutor berpengalaman, dan hasil terbukti.' }}">
    <meta name="keywords" content="bimbel, les privat, bimbingan belajar, lg learning, les matematika, les fisika, les kimia, persiapan utbk, snbt, masuk ptn">
    <meta name="author" content="L-G Learning">
    <meta property="og:title" content="{{ isset($title) ? $title . ' - ' . config('app.name', 'L-G Learning') : config('app.name', 'L-G Learning') }}">
    <meta property="og:description" content="{{ $settings['site_description'] ?? 'Raih prestasi akademik terbaik bersama L-G Learning.' }}">
    
    @php
        $siteSettingsLogo = \App\Models\SiteSetting::get('site_logo');
        $siteFavicon = $siteSettingsLogo ? asset('storage/' . $siteSettingsLogo) : asset('img/image.png');
    @endphp
    
    <meta property="og:image" content="{{ $siteFavicon }}">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta property="og:type" content="website">
    <link rel="icon" href="{{ $siteFavicon }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'L-G Learning') : config('app.name', 'L-G Learning') . ' - Bimbel Terbaik' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .loader-dots div { animation-timing-function: cubic-bezier(0, 1, 1, 0); }
        .loader-dots div:nth-child(1) { left: 8px; animation: loader-dots1 0.6s infinite; }
        .loader-dots div:nth-child(2) { left: 8px; animation: loader-dots2 0.6s infinite; }
        .loader-dots div:nth-child(3) { left: 32px; animation: loader-dots2 0.6s infinite; }
        .loader-dots div:nth-child(4) { left: 56px; animation: loader-dots3 0.6s infinite; }
        @keyframes loader-dots1 { 0% { transform: scale(0); } 100% { transform: scale(1); } }
        @keyframes loader-dots3 { 0% { transform: scale(1); } 100% { transform: scale(0); } }
        @keyframes loader-dots2 { 0% { transform: translate(0, 0); } 100% { transform: translate(24px, 0); } }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-white selection:bg-orange-100 selection:text-orange-600"
      x-data="{ isLoading: true }"
      x-init="window.addEventListener('load', () => { setTimeout(() => isLoading = false, 800); })">

    {{-- Global Loader --}}
    <div x-show="isLoading" 
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-white">
         <div class="text-center">
            <div class="relative w-20 h-20 mx-auto mb-4">
                 @php
                    $isUrl = str_contains($siteFavicon, 'http');
                 @endphp
                <img src="{{ $siteFavicon }}" class="w-full h-full object-contain animate-bounce">
                <div class="absolute inset-0 bg-white/30 backdrop-blur-sm hidden"></div>
            </div>
            <div class="loader-dots block relative w-20 h-5 mx-auto">
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
            </div>
         </div>
    </div>
    @props(['settings' => []])

    {{-- NAVBAR --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }" x-init="scrolled = (window.pageYOffset > 20)"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 'bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 py-3': scrolled || mobileOpen, 'bg-transparent py-5': !scrolled && !mobileOpen }"
        class="fixed w-full z-50 transition-all duration-300 top-0 left-0">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    @php
                        $siteLogo = \App\Models\SiteSetting::get('site_logo');
                        $logoUrl = $siteLogo ? asset('storage/' . $siteLogo) : asset('img/image.png');
                    @endphp
                    <img src="{{ $logoUrl }}" class="w-10 h-10 object-contain" alt="Logo">
                    <span class="text-xl font-bold tracking-tight text-gray-900 group-hover:text-orange-600 transition">
                        L-G <span class="text-orange-500">Learning</span>
                    </span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('home') ? 'text-orange-600' : '' }}">Beranda</a>
                    


                    <a href="{{ route('packages.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('packages.*') ? 'text-orange-600' : '' }}">Paket Belajar</a>
                        
                    <a href="{{ route('schedules.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('schedules.*') ? 'text-orange-600' : '' }}">Info Jadwal</a>
                    
                    <a href="{{ route('tutors.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('tutors.*') ? 'text-orange-600' : '' }}">Pengajar</a>

                    <a href="{{ route('gallery.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('gallery.*') ? 'text-orange-600' : '' }}">Galeri</a>
                    
                    <a href="{{ route('contact.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition {{ request()->routeIs('contact.*') ? 'text-orange-600' : '' }}">Kontak</a>
                    

                </div>

                {{-- Auth Buttons --}}
                <div class="hidden lg:flex items-center space-x-3">
                    @auth
                        @if(Auth::user()->isCentralAdmin() || Auth::user()->branch_id)
                        <a href="{{ Auth::user()->dashboard_url }}">
                            <x-buttons.primary class="!bg-orange-500 hover:!bg-orange-600 !shadow-orange-200">
                                Dashboard
                            </x-buttons.primary>
                        </a>
                        @else
                        <a href="{{ route('profile.edit') }}">
                            <x-buttons.primary class="!bg-orange-500 hover:!bg-orange-600 !shadow-orange-200">
                                Dashboard
                            </x-buttons.primary>
                        </a>
                        @endif
                    @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-gray-700 hover:text-orange-600 transition px-4 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}">
                        <button
                            class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200 hover:-translate-y-0.5 transform duration-200">
                            Daftar Sekarang
                        </button>
                    </a>
                    @endauth
                </div>

                {{-- Mobile Button --}}
                <div class="lg:hidden flex items-center">
                    <button @click="mobileOpen = !mobileOpen"
                        class="text-gray-600 hover:text-orange-500 focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg max-h-[80vh] overflow-y-auto">
            
            <div class="px-4 py-4 space-y-2 flex flex-col">
                <a href="{{ route('home') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('home') ? 'bg-orange-50 text-orange-600' : '' }}">Beranda</a>
                

                
                <a href="{{ route('packages.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('packages.*') ? 'bg-orange-50 text-orange-600' : '' }}">Paket Belajar</a>
                
                <a href="{{ route('schedules.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('schedules.*') ? 'bg-orange-50 text-orange-600' : '' }}">Info Jadwal</a>
                
                <a href="{{ route('tutors.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('tutors.*') ? 'bg-orange-50 text-orange-600' : '' }}">Pengajar</a>

                <a href="{{ route('gallery.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('gallery.*') ? 'bg-orange-50 text-orange-600' : '' }}">Galeri & Kegiatan</a>

                <a href="{{ route('contact.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('contact.*') ? 'bg-orange-50 text-orange-600' : '' }}">Kontak</a>
                


                <div class="pt-4 mt-2 border-t border-gray-100 flex flex-col gap-3 pb-2">
                    @auth
                        @if(Auth::user()->isCentralAdmin() || Auth::user()->branch_id)
                        <a href="{{ Auth::user()->dashboard_url }}"
                            class="w-full text-center py-3 bg-orange-500 text-white rounded-xl font-bold shadow-lg shadow-orange-200">Dashboard Admin</a>
                        @else
                        <a href="{{ route('profile.edit') }}"
                            class="w-full text-center py-3 bg-orange-500 text-white rounded-xl font-bold shadow-lg shadow-orange-200">Dashboard Siswa</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-3 text-gray-700 font-bold border border-gray-200 rounded-xl hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="w-full text-center py-3 bg-gray-900 text-white rounded-xl font-bold shadow-lg hover:bg-gray-800">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main>
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-50 border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                {{-- Brand --}}
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ $logoUrl }}" class="w-8 h-8 object-contain" alt="Logo">
                        <span class="text-lg font-bold text-gray-900">L-G Learning</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                        Membantu siswa mencapai potensi akademik terbaik mereka dengan metode pembelajaran yang personal
                        dan menyenangkan.
                    </p>
                    <div class="flex space-x-4">
                        {{-- TikTok --}}
                        @if(!empty($settings['contact_tiktok']))
                        <a href="{{ $settings['contact_tiktok'] }}" class="text-gray-400 hover:text-orange-500 transition" target="_blank" aria-label="TikTok">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                        @endif

                        {{-- Instagram --}}
                        @if(!empty($settings['contact_instagram']))
                        <a href="{{ $settings['contact_instagram'] }}" class="text-gray-400 hover:text-orange-500 transition" target="_blank" aria-label="Instagram">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif

                        {{-- Facebook --}}
                        @if(!empty($settings['contact_facebook']))
                        <a href="{{ $settings['contact_facebook'] }}" class="text-gray-400 hover:text-orange-500 transition" target="_blank" aria-label="Facebook">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                        </a>
                        @endif

                        {{-- WhatsApp --}}
                        @if(!empty($settings['contact_whatsapp']))
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', str_replace(['-', ' '], '', $settings['contact_whatsapp'])) }}" class="text-gray-400 hover:text-orange-500 transition" target="_blank" aria-label="WhatsApp">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Links --}}
                <div class="col-span-1">
                    <h3 class="font-bold text-gray-900 mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">Beranda</a></li>

                        <li><a href="{{ route('packages.index') }}" class="hover:text-orange-500 transition">Paket Belajar</a></li>
                        <li><a href="{{ route('schedules.index') }}" class="hover:text-orange-500 transition">Info Jadwal</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-orange-500 transition">Galeri</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-orange-500 transition">Kontak</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-bold text-gray-900 mb-4">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 text-orange-500">📍</span>
                            <span>{{ $settings['contact_address'] ?? 'Jl. Pendidikan No. 123, Jakarta Selatan' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-orange-500">📞</span>
                            <span>{{ $settings['contact_whatsapp'] ?? '0812-3456-7890' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-orange-500">✉️</span>
                            <span>{{ $settings['contact_email'] ?? 'info@lglearning.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} L-G Learning. All rights reserved.
                </p>
                <p class="text-xs text-gray-400">
                    Made with ❤️ for Education.
                </p>
            </div>
        </div>
    </footer>

    {{-- Toast Notification (Global) --}}
    {{-- Floating Action Buttons --}}
    <div class="fixed bottom-4 right-4 md:bottom-6 md:right-6 z-40 flex flex-col gap-3 md:gap-4" x-data="{ open: false }">
        
        {{-- Share Button --}}
        <div class="relative group">
            <span class="hidden md:block absolute right-full mr-3 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap pointer-events-none">
                Bagikan
            </span>
            <a href="https://wa.me/?text={{ urlencode('Halo! 👋 Saya menemukan website bimbingan belajar L-G Learning yang bagus banget. Cek infonya di sini ya: ' . url()->current()) }}" 
               target="_blank"
               class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-white text-green-600 rounded-full shadow-lg border border-gray-100 hover:bg-green-50 hover:scale-110 transition transform group-hover:rotate-12 animate-bounce-slow" style="animation-delay: 1.5s;">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
            </a>
        </div>

        {{-- Contact Button --}}
        <div class="relative group">
            <span class="hidden md:block absolute right-full mr-3 top-1/2 -translate-y-1/2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap pointer-events-none">
                Hubungi Admin
            </span>
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', str_replace(['-', ' '], '', $settings['contact_whatsapp'] ?? '081234567890')) }}?text={{ urlencode('Halo Admin L-G Learning, saya ingin bertanya tentang program bimbingan belajar.') }}"  
               target="_blank"
               class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-green-500 text-white rounded-full shadow-xl shadow-green-200 hover:bg-green-600 hover:scale-110 transition transform animate-bounce-slow">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </a>
        </div>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite;
        }
    </style>

    <x-ui.toast></x-ui.toast>
</body>

</html>