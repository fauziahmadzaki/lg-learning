<x-app-layout :breadcrumbs="['Dashboard Cabang' => null]">
    <x-slot name="pageTitle">Area Tutor</x-slot>

    <div class="space-y-6">

        {{-- 1. WELCOME BANNER & NEXT CLASS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- A. Welcome Message (Kiri - Lebar) --}}
            <div
                class="md:col-span-2 bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                {{-- Hiasan Background --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl">
                </div>

                <div class="relative z-10">
                    <h2 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-indigo-100 mt-1">Siap menginspirasi siswa hari ini?</p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <div
                            class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
                        </div>
                        <div
                            class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Cabang ID: {{ request()->route('branch') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- B. Highlight "NEXT CLASS" (Kanan - Penting) --}}
            <div
                class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition">
                <div
                    class="absolute top-0 right-0 bg-indigo-500 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg uppercase tracking-wider">
                    Next Class
                </div>

                <div class="flex items-start gap-4 mt-2">
                    {{-- Waktu --}}
                    <div
                        class="flex flex-col items-center justify-center bg-indigo-50 rounded-xl w-16 h-16 text-indigo-700 border border-indigo-100">
                        <span class="text-lg font-bold">14:00</span>
                        <span class="text-[10px] uppercase font-bold">WIB</span>
                    </div>

                    {{-- Detail --}}
                    <div>
                        <h3 class="text-gray-900 font-bold truncate">Matematika SD</h3>
                        <p class="text-sm text-gray-500">Siswa: <span class="font-medium text-indigo-600">Budi
                                Santoso</span></p>
                        <div class="mt-2">
                            <button
                                class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition shadow-sm shadow-indigo-200">
                                Mulai Sesi &rarr;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. STATS GRID (Ringkasan Kinerja) --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            {{-- Stat 1: Jadwal Hari Ini --}}
            <div
                class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col items-center text-center">
                <div class="p-2 rounded-full bg-blue-50 text-blue-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-gray-800">4</h4>
                <p class="text-xs font-medium text-gray-400 uppercase">Sesi Hari Ini</p>
            </div>

            {{-- Stat 2: Total Siswa Diampu --}}
            <div
                class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col items-center text-center">
                <div class="p-2 rounded-full bg-purple-50 text-purple-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-gray-800">12</h4>
                <p class="text-xs font-medium text-gray-400 uppercase">Siswa Aktif</p>
            </div>

            {{-- Stat 3: Total Jam Bulan Ini --}}
            <div
                class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col items-center text-center">
                <div class="p-2 rounded-full bg-orange-50 text-orange-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-gray-800">28</h4>
                <p class="text-xs font-medium text-gray-400 uppercase">Jam Bulan Ini</p>
            </div>

            {{-- Stat 4: Rating (Opsional) --}}
            <div
                class="p-4 rounded-xl border border-gray-100 bg-white shadow-sm flex flex-col items-center text-center">
                <div class="p-2 rounded-full bg-yellow-50 text-yellow-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-gray-800">5.0</h4>
                <p class="text-xs font-medium text-gray-400 uppercase">Rating Tutor</p>
            </div>
        </div>

        {{-- 3. MAIN CONTENT: JADWAL & AKTIVITAS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Bagian Kiri: Jadwal Mengajar (List) --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">📅 Jadwal Mengajar Hari Ini</h3>
                    <a href="#" class="text-xs text-indigo-600 hover:underline">Lihat Kalender Full</a>
                </div>

                <div class="divide-y divide-gray-100">
                    {{-- Item Jadwal 1 --}}
                    <div class="p-4 hover:bg-gray-50 transition flex items-center gap-4">
                        <div class="flex-shrink-0 w-16 text-center">
                            <span class="block text-gray-900 font-bold">14:00</span>
                            <span class="block text-xs text-gray-400">90 Menit</span>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-gray-900 font-bold">Matematika - Pecahan</h4>
                            <p class="text-sm text-gray-500">Siswa: <span class="text-indigo-600 font-medium">Budi
                                    Santoso</span> (SD Kelas 5)</p>
                        </div>
                        <div>
                            @php $status = 'upcoming'; /* Logic dummy */ @endphp
                            @if($status == 'done')
                            <span
                                class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-lg font-bold">Selesai</span>
                            @else
                            <button
                                class="px-3 py-1.5 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 text-xs rounded-lg font-bold transition">
                                Absen
                            </button>
                            @endif
                        </div>
                    </div>

                    {{-- Item Jadwal 2 --}}
                    <div class="p-4 hover:bg-gray-50 transition flex items-center gap-4">
                        <div class="flex-shrink-0 w-16 text-center">
                            <span class="block text-gray-900 font-bold">16:00</span>
                            <span class="block text-xs text-gray-400">90 Menit</span>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-gray-900 font-bold">Bahasa Inggris - Grammar</h4>
                            <p class="text-sm text-gray-500">Siswa: <span class="text-indigo-600 font-medium">Siti
                                    Aminah</span> (SMP Kelas 1)</p>
                        </div>
                        <div>
                            <button
                                class="px-3 py-1.5 border border-gray-300 text-gray-400 cursor-not-allowed text-xs rounded-lg font-bold"
                                disabled>
                                Menunggu
                            </button>
                        </div>
                    </div>

                    {{-- Item Jadwal 3 --}}
                    <div class="p-4 hover:bg-gray-50 transition flex items-center gap-4 opacity-60">
                        <div class="flex-shrink-0 w-16 text-center">
                            <span class="block text-gray-900 font-bold">18:30</span>
                            <span class="block text-xs text-gray-400">60 Menit</span>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-gray-900 font-bold">Calistung (Privat)</h4>
                            <p class="text-sm text-gray-500">Siswa: <span class="text-indigo-600 font-medium">Dek
                                    Nanda</span> (TK B)</p>
                        </div>
                        <div>
                            <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded-lg font-bold">Nanti</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Quick Actions & Announcement --}}
            <div class="space-y-6">

                {{-- Menu Cepat --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-indigo-50 hover:border-indigo-200 group transition">
                            <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-700">Input Jurnal
                                Manual</span>
                        </button>

                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-purple-50 hover:border-purple-200 group transition">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Lihat Data
                                Siswa</span>
                        </button>
                    </div>
                </div>

                {{-- Pengumuman Mini --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-yellow-100">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-yellow-800 relative z-10 mb-1">📢 Info Cabang</h3>
                    <p class="text-sm text-yellow-700 relative z-10 leading-relaxed">
                        Rapat evaluasi tutor akan diadakan hari Jumat, pk 13.00 WIB. Mohon hadir tepat waktu.
                    </p>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>