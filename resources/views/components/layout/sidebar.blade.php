<aside
    class="hidden lg:flex flex-col fixed top-0 left-0 w-64 h-screen bg-white shadow-[4px_0_24px_rgba(0,0,0,0.02)] border-r border-gray-100 pt-20 transition-all duration-300 z-40">

    {{-- AREA MENU (Scrollable) --}}
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            {{-- MENU UTAMA --}}
        <x-layout.sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </x-slot>
            Dashboard
        </x-layout.sidebar-link>

        {{-- GROUP: MASTER DATA --}}
        <x-layout.sidebar-label>Master Data</x-layout.sidebar-label>

        {{-- Menu Siswa --}}
        <x-layout.sidebar-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </x-slot>
            Data Siswa
        </x-layout.sidebar-link>

        {{-- Menu Tutor --}}
        <x-layout.sidebar-link :href="route('admin.tutors.index')" :active="request()->routeIs('admin.tutors.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </x-slot>
            Data Tutor
        </x-layout.sidebar-link>

        {{-- Menu Paket --}}
        <x-layout.sidebar-link :href="route('admin.packages.index')" :active="request()->routeIs('admin.packages.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </x-slot>
            Paket Belajar
        </x-layout.sidebar-link>

        {{-- Menu Kategori Paket --}}
        <x-layout.sidebar-link :href="route('admin.package-categories.index')" :active="request()->routeIs('admin.package-categories.*')">
             <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
             </x-slot>
             Kategori Paket
        </x-layout.sidebar-link>

        {{-- Menu Jadwal Belajar --}}
        <x-layout.sidebar-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot>
            Jadwal Belajar
        </x-layout.sidebar-link>

        {{-- Menu Cabang --}}
        <x-layout.sidebar-link :href="route('admin.branches.index')" :active="request()->routeIs('admin.branches.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </x-slot>
            Data Cabang
        </x-layout.sidebar-link>

        {{-- Menu Galeri (Moved from Bottom) --}}
        <x-layout.sidebar-link :href="route('admin.contents.index')" :active="request()->routeIs('admin.contents.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot>
            Galeri & Konten
        </x-layout.sidebar-link>

        {{-- GROUP: KEUANGAN --}}
        <x-layout.sidebar-label>Keuangan</x-layout.sidebar-label>

        {{-- Menu Transaksi --}}
        <x-layout.sidebar-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </x-slot>
            Riwayat Transaksi
        </x-layout.sidebar-link>

        {{-- GROUP: LAPORAN --}}
        <x-layout.sidebar-label>Laporan & Log</x-layout.sidebar-label>

        {{-- Menu Laporan Keuangan --}}
        <x-layout.sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </x-slot>
            Laporan Keuangan
        </x-layout.sidebar-link>

        {{-- Menu Laporan Siswa --}}
        <x-layout.sidebar-link :href="route('admin.reports.students')" :active="request()->routeIs('admin.reports.students')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </x-slot>
            Laporan Siswa
        </x-layout.sidebar-link>

        {{-- Menu Activity Logs --}}
        <x-layout.sidebar-link :href="route('admin.activity-logs.index')" :active="request()->routeIs('admin.activity-logs.index*')">
             <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
             </x-slot>
             Log Aktivitas
        </x-layout.sidebar-link>

        {{-- GROUP: PENGATURAN --}}
        <x-layout.sidebar-label>Pengaturan</x-layout.sidebar-label>

        {{-- Menu Pengaturan --}}
        <x-layout.sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
            <x-slot name="icon">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot>
            Pengaturan Website
        </x-layout.sidebar-link>

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