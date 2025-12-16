@props(['pageTitle', 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">

        {{-- 1. Sidebar (Fixed Left) --}}
        <x-sidebar />

        {{-- 2. Navbar (Fixed Top) --}}
        @include('layouts.navigation')

        {{-- 3. Main Content Wrapper --}}
        {{-- lg:pl-64 = Geser kanan untuk Sidebar --}}
        {{-- pt-20    = Geser bawah untuk Navbar --}}
        <main class="lg:pl-64 pt-20 transition-all duration-300">

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

                                @if(!empty($breadcrumbs))
                                <div>
                                    <x-breadcrumb :links="$breadcrumbs" />
                                </div>
                                @endif
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
    <x-toast></x-toast>
</body>

</html>