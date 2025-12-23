@props(['pageTitle', 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags (Basic for App) --}}
    <meta name="robots" content="noindex, nofollow"> {{-- Dashboard shouldn't be indexed generally --}}
    <meta name="author" content="L-G Learning">

    @php
        $siteSettingsLogo = \App\Models\SiteSetting::get('site_logo');
        $siteFavicon = $siteSettingsLogo ? asset('storage/' . $siteSettingsLogo) : asset('img/image.png');
    @endphp
    <link rel="icon" href="{{ $siteFavicon }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

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

<body class="font-sans antialiased bg-gray-50"
      x-data="{ isLoading: true }"
      x-init="window.addEventListener('load', () => { setTimeout(() => isLoading = false, 800); })">

    {{-- Global Loader --}}
    <div x-show="isLoading" 
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-white/80 backdrop-blur-sm">
         <div class="text-center">
            <div class="loader-dots block relative w-20 h-5 mx-auto">
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
                <div class="absolute top-0 w-3 h-3 rounded-full bg-orange-500"></div>
            </div>
         </div>
    </div>
    <div class="min-h-screen">

        {{-- 1. Sidebar (Fixed Left) --}}
        @php
            $routeBranch = request()->route('branch');
        @endphp

        @if($routeBranch && $routeBranch instanceof \App\Models\Branch)
            <x-layout.branch-sidebar :branch="$routeBranch" />
        @elseif(Auth::user()->isCentralAdmin())
            <x-layout.sidebar />
        @elseif(Auth::user()->branch_id)
            <x-layout.branch-sidebar :branch="Auth::user()->branch" />
        @endif

        {{-- 2. Navbar (Fixed Top) --}}
        @include('layouts.navigation')

        {{-- 3. Main Content Wrapper --}}
        {{-- lg:pl-64 = Geser kanan untuk Sidebar (Hanya jika ada sidebar) --}}
        {{-- pt-20    = Geser bawah untuk Navbar --}}
        <main class="{{ (Auth::user()->isCentralAdmin() || Auth::user()->branch_id) ? 'lg:pl-64' : '' }} pt-20 transition-all duration-300">

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    {{--
                        CONTAINER PUTIH (DIKEMBALIKAN) 
                        Ini membuat semua konten berada di dalam kotak putih besar.
                    --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                        <div class="p-6 md:p-8 space-y-4">

                            {{-- Header Halaman (Judul & Breadcrumb) --}}
                            <div class="border-b border-gray-100 pb-4 mb-4">
                                <h1 class="text-gray-800 text-3xl font-bold mb-2">{{ $pageTitle ?? "Page" }}</h1>

                                <div>
                                    <x-layout.breadcrumb :links="$breadcrumbs" />
                                </div>
                            </div>

                            {{-- CONTENT SLOT --}}
                            <div class="mt-4">
                                {{ $slot }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>

    {{-- Toast Notification (Global) --}}
    <x-ui.toast></x-ui.toast>
</body>

</html>