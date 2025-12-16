<x-app-layout :breadcrumbs="['Manajemen Siswa' => null]">
    <x-slot name="pageTitle">Data Siswa</x-slot>

    {{-- Setup Alpine Data untuk Modal Hapus --}}
    <div x-data="{ deleteUrl: '', studentName: '' }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Siswa Bimbel</h2>
                <form method="GET" action="{{ route('students.index') }}" class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, sekolah, atau email..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200">
                </form>
            </div>

            {{-- Kanan: Tombol Tambah --}}
            <a href="{{ route('students.create') }}">
                <x-primary-button class="flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                    Daftar Siswa Baru
                </x-primary-button>
            </a>
        </div>

        {{-- SECTION: Grid Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($students as $student)
            <div
                class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

                {{-- Badge Status (Pojok Kanan Atas) --}}
                <div class="absolute top-4 right-4 z-10">
                    @php $color = $student->status_color; @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-{{ $color }}-100 border border-{{ $color }}-200 text-{{ $color }}-700 shadow-sm uppercase tracking-wide">
                        {{ $student->status }}
                    </span>
                </div>

                {{-- Bagian Atas: Profil --}}
                <div class="p-6 pb-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar Inisial --}}
                        <div
                            class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-2xl border-4 border-white shadow-md shrink-0">
                            {{ substr($student->name, 0, 1) }}
                        </div>

                        {{-- Info Nama --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-indigo-600 transition">
                                {{ $student->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Join: {{ $student->join_date->format('d M Y') }}
                            </p>
                            <span
                                class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">
                                Kelas {{ $student->grade }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Separator --}}
                <div class="px-6">
                    <div class="border-t border-gray-100"></div>
                </div>

                {{-- Bagian Tengah: Detail Sekolah & Kontak --}}
                <div class="px-6 py-4 flex-1 flex flex-col gap-3">

                    {{-- Sekolah --}}
                    <div class="flex items-start gap-3">
                        <div class="bg-indigo-50 p-1.5 rounded-lg text-indigo-600 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Asal Sekolah</p>
                            <p class="text-sm text-gray-700 font-medium line-clamp-1">{{ $student->school }}</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-50 p-1.5 rounded-lg text-blue-600 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Email Siswa</p>
                            <p class="text-sm text-gray-700 font-medium truncate">{{ $student->email }}</p>
                        </div>
                    </div>

                    {{-- Ortu --}}
                    <div class="flex items-start gap-3">
                        <div class="bg-green-50 p-1.5 rounded-lg text-green-600 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase">HP Orang Tua</p>
                            <p class="text-sm text-gray-700 font-medium">{{ $student->parent_phone }}</p>
                        </div>
                    </div>

                </div>

                {{-- Footer: Actions --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                    <div class="text-xs text-gray-400 font-medium">
                        ID: #{{ $student->id }}
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Edit Button --}}
                        <a href="{{ route('students.edit', $student) }}"
                            class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                            title="Edit Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        {{-- Delete Button (Trigger Modal) --}}
                        {{-- NOTE: Pastikan route students.destroy sudah ada --}}
                        {{-- <button 
                            x-on:click.prevent="deleteUrl = '{{ route('students.destroy', $student) }}'; studentName =
                        '{{ addslashes($student->name) }}'; $dispatch('open-modal', 'confirm-student-deletion')"
                        class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" title="Hapus
                        Data">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        </button> --}}
                    </div>
                </div>

            </div>
            @empty
            {{-- Empty State --}}
            <div
                class="col-span-full flex flex-col items-center justify-center p-16 bg-white rounded-2xl border border-dashed border-gray-300 text-center">
                <div class="bg-indigo-50 p-4 rounded-full mb-4">
                    <svg class="h-10 w-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Belum ada Siswa</h3>
                <p class="text-gray-500 mt-2 mb-8 max-w-sm">Mulai daftarkan siswa baru untuk mengelola kelas dan
                    pembayaran.</p>
                <a href="{{ route('students.create') }}">
                    <x-primary-button class="px-6 py-2.5">Daftar Siswa Baru</x-primary-button>
                </a>
            </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $students->links() }}
        </div>

        {{-- MODAL HAPUS --}}
        <x-modal name="confirm-student-deletion" focusable>
            <form method="post" :action="deleteUrl" class="p-6">
                @csrf
                @method('DELETE')

                <div class="flex items-center gap-3 mb-4 text-red-600">
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ __('Hapus Data Siswa?') }}
                    </h2>
                </div>

                <p class="mt-1 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus siswa <strong class="text-gray-900"
                        x-text="studentName"></strong>?
                    <br><br>
                    <span class="text-red-500 text-xs font-bold uppercase">Peringatan:</span> Semua riwayat pembayaran
                    dan data akademik siswa ini akan dihapus permanen.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button>
                        {{ __('Ya, Hapus Siswa') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>