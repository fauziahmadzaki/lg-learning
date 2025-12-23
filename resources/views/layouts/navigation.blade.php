<nav x-data="{ open: false }"
    class="bg-white border-b border-gray-100 fixed top-0 w-full z-30 {{ (Auth::user()->isCentralAdmin() || Auth::user()->branch_id) ? 'lg:pl-64' : '' }} transition-all duration-300">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-4">

                <div class="-me-2 flex items-center lg:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="hidden sm:flex flex-col">
                    <h1 class="font-bold text-lg text-gray-800 leading-tight flex items-center gap-2">
                        Halo, {{ Auth::user()->name }} <span class="text-xl">👋</span>
                    </h1>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">

                {{-- NOTIFICATION DISABLED --}}
                {{-- <button
                    class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition relative">
                    <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button> --}}
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->dashboard_url }}">
                        @php
                            $siteLogo = \App\Models\SiteSetting::get('site_logo');
                            $logoUrl = $siteLogo ? asset('storage/' . $siteLogo) : asset('img/image.png');
                        @endphp
                        <img src="{{ $logoUrl }}" alt="Logo" class="block h-10 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <div class="relative ms-3">
                    <x-layout.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                {{-- Avatar Logic --}}
                                @if(Auth::user()->tutor?->image)
                                    <div class="shrink-0">
                                         <img src="{{ asset('storage/' . Auth::user()->tutor->image) }}" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                    </div>
                                @else
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif

                                <div class="hidden sm:block text-left">
                                    <div class="text-gray-800 font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-gray-400">{{ Auth::user()->role_label ?? 'User' }}</div>
                                </div>
                                <div class="ms-1 hidden sm:block">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400">
                                Manajemen Akun
                            </div>
                            <x-layout.dropdown-link :href="route('profile.edit')">
                                {{ __('Profile Saya') }}
                            </x-layout.dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-layout.dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50">
                                    {{ __('Keluar') }}
                                </x-layout.dropdown-link>
                            </form>
                        </x-slot>
                    </x-layout.dropdown>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" 
        class="hidden lg:hidden border-t border-gray-100 bg-white shadow-lg fixed bottom-0 left-0 right-0 top-20 overflow-y-auto z-40"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">

@php
            $isBranchRoute = request()->routeIs('branch.*');
            // Try to get branch from Route Parameter first (for Admin viewing Branch), then from User (for Branch Admin)
            $currentBranch = request()->route('branch') ?? (Auth::user()->branch_id ? Auth::user()->branch : null);
        @endphp

        <div class="pt-2 pb-3 space-y-1">
            @if($isBranchRoute && $currentBranch)
                <x-layout.branch-mobile-menu :branch="$currentBranch" />
            @elseif(Auth::user()->isCentralAdmin())
                <x-layout.admin-mobile-menu />
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center gap-3">
                @if(Auth::user()->tutor?->image)
                    <div class="shrink-0">
                         <img src="{{ asset('storage/' . Auth::user()->tutor->image) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    </div>
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-layout.responsive-nav-link :href="route('profile.edit')" class="rounded-md">
                    {{ __('Profile') }}
                </x-layout.responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-layout.responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-600 rounded-md">
                        {{ __('Keluar') }}
                    </x-layout.responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

{{--
    PENTING:
    Component Sidebar jangan dipanggil di sini.
    Sidebar harusnya dipanggil di file Layout utama (layouts/app.blade.php).
    Jika dipanggil di sini, layoutnya akan berantakan (sidebar muncul di bawah navbar).
--}}