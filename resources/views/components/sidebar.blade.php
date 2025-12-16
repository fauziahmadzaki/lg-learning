<aside
    class="hidden lg:flex flex-col fixed top-0 left-0 w-64 h-screen bg-white shadow-[4px_0_24px_rgba(0,0,0,0.02)] border-r border-gray-100 pt-20 transition-all duration-300 z-40">

    {{-- AREA MENU (Scrollable) --}}
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        {{-- MENU UTAMA --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            {{-- Icon Dashboard --}}
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        {{-- GROUP: MASTER DATA --}}
        <div class="pt-5 pb-2">
            <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                Master Data
            </p>
        </div>

        {{-- Menu Siswa (BARU) --}}
        <a href="{{ route('students.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('students.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('students.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <span class="font-medium text-sm">Data Siswa</span>
        </a>

        {{-- Menu Tutor --}}
        <a href="{{ route('tutors.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('tutors.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('tutors.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="font-medium text-sm">Kelola Tutor</span>
        </a>

        {{-- Menu Paket --}}
        <a href="{{ route('packages.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('packages.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('packages.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="font-medium text-sm">Kelola Paket</span>
        </a>

        {{-- Menu Cabang --}}
        <a href="{{ route('branches.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branches.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branches.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="font-medium text-sm">Kelola Cabang</span>
        </a>

        {{-- GROUP: KEUANGAN (BARU) --}}
        <div class="pt-5 pb-2">
            <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                Keuangan
            </p>
        </div>

        {{-- Menu Transaksi (BARU) --}}
        {{-- <a href="{{ route('transactions.index') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group
        {{ request()->routeIs('transactions.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="w-5 h-5 transition-colors {{ request()->routeIs('transactions.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
        </svg>
        <span class="font-medium text-sm">Riwayat Transaksi</span>
        </a> --}}

        {{-- GROUP: LAPORAN --}}
        <div class="pt-5 pb-2">
            <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                Laporan & Akun
            </p>
        </div>

        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="font-medium text-sm">Laporan</span>
        </a>
    </div>

    {{-- FOOTER: PROFILE USER --}}
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
            {{-- Avatar Inisial --}}
            <div
                class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>

            {{-- Nama & Email --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                    title="Log Out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>