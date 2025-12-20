<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LG Learning') }} - Bimbel Terbaik</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-800 bg-white selection:bg-orange-100 selection:text-orange-600">
    @props(['settings' => []])

    {{-- NAVBAR --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }" x-init="scrolled = (window.pageYOffset > 20)"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 'bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 py-3': scrolled || mobileOpen, 'bg-transparent py-5': !scrolled && !mobileOpen }"
        class="fixed w-full z-50 transition-all duration-300 top-0 left-0">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <div class="flex items-center gap-2">
                    <div
                        class="bg-gradient-to-br from-orange-400 to-yellow-500 text-white p-2 rounded-xl shadow-lg shadow-orange-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900">
                        LG <span class="text-orange-500">Learning</span>
                    </span>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Beranda</a>
                    <a href="#about" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Daftar
                        Tutor</a>
                    <a href="{{ route('packages.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Paket
                        Belajar</a>
                    <a href="/galeri"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Galeri</a>
                    <a href="#contact"
                        class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Kontak</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden lg:flex items-center space-x-3">
                    @auth

                    @if(Auth::user()->isCentralAdmin() || Auth::user()->branch_id)
                    <a href="{{ Auth::user()->dashboard_url }}">
                        <x-primary-button class="!bg-orange-500 hover:!bg-orange-600 !shadow-orange-200">
                            Dashboard
                        </x-primary-button>
                    </a>
                    @else
                    <a href="{{ route('profile.edit') }}">
                        <x-primary-button class="!bg-orange-500 hover:!bg-orange-600 !shadow-orange-200">
                            Dashboard
                        </x-primary-button>
                    </a>
                    @endif
                    @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-gray-700 hover:text-orange-600 transition px-4 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}">
                        <button
                            class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                            Daftar Sekarang
                        </button>
                    </a>
                    @endauth
                </div>

                {{-- Mobile Button --}}
                <div class="lg:hidden flex items-center">
                    <button @click="mobileOpen = !mobileOpen"
                        class="text-gray-600 hover:text-orange-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition
            class="lg:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
            <div class="px-4 py-4 space-y-2 flex flex-col">
                <a href="{{ route('home') }}"
                    class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">Beranda</a>
                <a href="#about"
                    class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">Tentang</a>
                <a href="#packages"
                    class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">Paket
                    Belajar</a>
                <a href="#gallery"
                    class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">Galeri</a>
                <a href="#contact"
                    class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition">Kontak</a>
                <div class="pt-4 border-t border-gray-100 flex flex-col gap-2">
                    @auth

                    @if(Auth::user()->isCentralAdmin() || Auth::user()->branch_id)
                    <a href="{{ Auth::user()->dashboard_url }}"
                        class="w-full text-center py-2 bg-orange-500 text-white rounded-lg font-bold">Dashboard</a>
                    @else
                    <a href="{{ route('profile.edit') }}"
                        class="w-full text-center py-2 bg-orange-500 text-white rounded-lg font-bold">Dashboard</a>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 text-gray-700 font-bold">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="w-full text-center py-2 bg-gray-900 text-white rounded-lg font-bold">Daftar</a>
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
                        <div class="bg-gradient-to-br from-orange-400 to-yellow-500 text-white p-1.5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-gray-900">LG Learning</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                        Membantu siswa mencapai potensi akademik terbaik mereka dengan metode pembelajaran yang personal
                        dan menyenangkan.
                    </p>
                    <div class="flex space-x-4">
                        {{-- Social Icons (Dummy) --}}
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition"><span
                                class="sr-only">Facebook</span><svg class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg></a>
                            </svg></a>
                        @if(!empty($settings['contact_instagram']))
                        <a href="https://instagram.com/{{ str_replace('@', '', $settings['contact_instagram']) }}" class="text-gray-400 hover:text-orange-500 transition" target="_blank"><span
                                class="sr-only">Instagram</span><svg class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.407-.06 4.123-.06h.08zm0 1.802h-.08c-2.588 0-2.9.01-3.791.048-.797.037-1.218.176-1.503.287-.377.147-.648.323-.928.603-.28.28-.456.551-.603.928-.11.285-.25.706-.287 1.503-.038.89-.047 1.202-.047 3.791v.08c0 2.588.01 2.9.048 3.791.037.797.176 1.218.287 1.503.147.377.323.648.603.928.28.28.551.456.928.603.285.11.706.25 1.503.287.89.038 1.202.047 3.791.047h.08c2.588 0 2.9-.01 3.791-.048.797-.037 1.218-.176 1.503-.287.377-.147.648-.323.928-.603.28-.28.456-.551.603-.928.11-.285.25-.706.287-1.503.038-.89.047-1.202.047-3.791v-.08c0-2.588-.01-2.9-.048-3.791-.037-.797-.176-1.218-.287-1.503-.147-.377-.323-.648-.603-.928-.28-.28-.551-.456-.928-.603-.285-.11-.706-.25-1.503-.287-.89-.038-1.202-.047-3.791-.047zM12.315 5.836a6.16 6.16 0 100 12.321 6.16 6.16 0 000-12.321zm0 1.802a4.358 4.358 0 110 8.716 4.358 4.358 0 010-8.716zm6.338 1.135a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg></a>
                        @endif
                    </div>
                </div>

                {{-- Links --}}
                <div class="col-span-1">
                    <h3 class="font-bold text-gray-900 mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#home" class="hover:text-orange-500 transition">Beranda</a></li>
                        <li><a href="#about" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('packages.index') }}" class="hover:text-orange-500 transition">Paket Belajar</a></li>
                        <li><a href="#gallery" class="hover:text-orange-500 transition">Galeri</a></li>
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
                    &copy; {{ date('Y') }} LG Learning. All rights reserved.
                </p>
                <p class="text-xs text-gray-400">
                    Made with ❤️ for Education.
                </p>
            </div>
        </div>
    </footer>

</body>

</html>