<x-app-layout :breadcrumbs="['Dashboard' => null]">
    <x-slot name="pageTitle">Overview</x-slot>

    <div class="space-y-6">

        {{-- 1. WELCOME BANNER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-sm text-gray-500">Berikut adalah ringkasan aktivitas bimbel hari ini.</p>
            </div>
            <div class="hidden sm:block">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></span>
                    Sistem Online
                </span>
            </div>
        </div>

        {{-- 2. STATS GRID (Placeholder Data) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card 1: Total Cabang --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Cabang</p>
                    <h4 class="text-xl font-bold text-gray-800">12</h4>
                </div>
            </div>

            {{-- Card 2: Total Tutor --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Tutor Aktif</p>
                    <h4 class="text-xl font-bold text-gray-800">45</h4>
                </div>
            </div>

            {{-- Card 3: Paket Terjual --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Paket Terjual</p>
                    <h4 class="text-xl font-bold text-gray-800">1,204</h4>
                </div>
            </div>

            {{-- Card 4: Pendapatan (Bulan Ini) --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Omset (Bln)</p>
                    <h4 class="text-xl font-bold text-gray-800">Rp 85jt</h4>
                </div>
            </div>
        </div>

        {{-- 3. CONTENT SECTION (Split Layout) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Bagian Kiri: Placeholder Grafik --}}
            <div
                class="lg:col-span-2 border border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center min-h-[300px] bg-gray-50/50">
                <div class="bg-white p-4 rounded-full shadow-sm mb-3">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <h3 class="text-gray-900 font-medium">Statistik Pendaftaran</h3>
                <p class="text-sm text-gray-500 mt-1">Grafik pertumbuhan siswa akan ditampilkan di sini.</p>
                <button class="mt-4 text-sm text-indigo-600 hover:underline">Lihat Laporan Lengkap &rarr;</button>

                {{-- Visual Bar Palsu --}}
                <div class="flex items-end gap-2 mt-8 h-24 opacity-50">
                    <div class="w-8 bg-indigo-300 rounded-t h-12"></div>
                    <div class="w-8 bg-indigo-400 rounded-t h-16"></div>
                    <div class="w-8 bg-indigo-500 rounded-t h-20"></div>
                    <div class="w-8 bg-indigo-600 rounded-t h-14"></div>
                    <div class="w-8 bg-indigo-400 rounded-t h-24"></div>
                </div>
            </div>

            {{-- Bagian Kanan: Aktivitas Terbaru --}}
            <div class="border border-gray-100 rounded-xl p-4 bg-gray-50">
                <h3 class="text-gray-800 font-bold mb-4 text-sm uppercase tracking-wide">Aktivitas Terbaru</h3>

                <div class="space-y-4">
                    {{-- Item 1 --}}
                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-medium">Budi Santoso mendaftar paket <span
                                    class="text-indigo-600">Super Intensif</span></p>
                            <p class="text-xs text-gray-400">Baru saja</p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-medium">Pembayaran diterima dari <span
                                    class="text-gray-600">Siti Aminah</span></p>
                            <p class="text-xs text-gray-400">15 menit lalu</p>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-medium">Tutor baru <span class="text-gray-600">Pak
                                    Joko</span> ditambahkan</p>
                            <p class="text-xs text-gray-400">1 jam lalu</p>
                        </div>
                    </div>

                    {{-- Item 4 --}}
                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 font-medium">Cabang <span class="text-gray-600">Surabaya
                                    Barat</span> diperbarui</p>
                            <p class="text-xs text-gray-400">Hari ini, 09:00</p>
                        </div>
                    </div>
                </div>

                <button
                    class="w-full mt-6 py-2 text-xs font-medium text-gray-500 border border-gray-200 rounded-lg hover:bg-white hover:text-indigo-600 transition">
                    Lihat Semua Aktivitas
                </button>
            </div>

        </div>

        {{-- 4. QUICK ACTIONS --}}
        <div class="pt-4 border-t border-gray-100">
            <h3 class="text-gray-800 font-bold mb-4 text-sm uppercase tracking-wide">Akses Cepat</h3>
            <div class="flex gap-3 overflow-x-auto pb-2">
                <a href="{{ route('admin.branches.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition whitespace-nowrap">
                    + Tambah Cabang
                </a>
                <a href="{{ route('admin.tutors.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-100 transition whitespace-nowrap">
                    + Tambah Tutor
                </a>
                <a href="{{ route('admin.packages.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition whitespace-nowrap">
                    + Buat Paket
                </a>
            </div>
        </div>

    </div>
</x-app-layout>