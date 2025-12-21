@props(['branch'])

<aside
    class="hidden lg:flex flex-col fixed top-0 left-0 w-64 h-screen bg-white shadow-[4px_0_24px_rgba(0,0,0,0.02)] border-r border-gray-100 pt-20 transition-all duration-300 z-40">

    {{-- AREA MENU (Scrollable) --}}
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        <div class="pt-2 pb-6 px-3">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Cabang</h2>
                    <p class="font-bold text-gray-800 text-sm truncate w-32">{{ $branch->name }}</p>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="mt-4 flex items-center gap-2 p-2 bg-indigo-50 text-indigo-700 rounded text-xs hover:bg-indigo-100 transition border border-indigo-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span class="font-bold">Kembali ke Dashboard Pusat</span>
            </a>
            @endif
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('branch.dashboard', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        {{-- GROUP: AKADEMIK --}}
        <div class="pt-5 pb-2">
            <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                Akademik
            </p>
        </div>

        {{-- Siswa --}}
        <a href="{{ route('branch.students.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.students.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.students.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="font-medium text-sm">Data Siswa</span>
        </a>

        {{-- Paket Belajar --}}
        <a href="{{ route('branch.packages.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.packages.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.packages.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="font-medium text-sm">Paket Belajar</span>
        </a>

        {{-- Kelas / Paket Management (Courses) --}}
        <a href="{{ route('branch.courses.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.courses.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.courses.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <span class="font-medium text-sm">Data Kelas</span>
        </a>

        {{-- Jadwal Belajar (New) --}}
        <a href="{{ route('branch.schedules.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.schedules.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.schedules.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium text-sm">Jadwal Belajar</span>
        </a>

            {{-- GROUP: KEUANGAN --}}
        <div class="pt-5 pb-2">
            <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                Keuangan
            </p>
        </div>

        {{-- Riwayat Transaksi (New) --}}
        <a href="{{ route('branch.transactions.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.transactions.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.transactions.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium text-sm">Riwayat Transaksi</span>
        </a>

        {{-- Laporan Keuangan --}}
        <a href="{{ route('branch.reports.index', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.reports.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.reports.index') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="font-medium text-sm">Laporan Pemasukan</span>
        </a>

        {{-- Laporan Siswa --}}
        <a href="{{ route('branch.reports.students', $branch) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group {{ request()->routeIs('branch.reports.students') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 transition-colors {{ request()->routeIs('branch.reports.students') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="font-medium text-sm">Laporan Siswa</span>
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
