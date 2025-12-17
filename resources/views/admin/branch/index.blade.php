@php
$breadcrumbs = [
'Cabang' => route('branches.index')
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Kelola Cabang</x-slot>

    {{-- Setup Alpine Data --}}
    <div x-data="{ deleteUrl: '', branchName: '' }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Lokasi Cabang</h2>
                <div class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari nama cabang atau alamat..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200">
                </div>
            </div>

            {{-- Kanan: Tombol Tambah --}}
            <a href="{{ route('branches.create') }}">
                <x-primary-button class="flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Cabang
                </x-primary-button>
            </a>
        </div>

        {{-- SECTION: Grid Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($branches as $branch)
            <div
                class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                {{-- Card Header: Visual Placeholder --}}
                <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 relative overflow-hidden">
                    {{-- Pattern Background --}}
                    <div
                        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                    </div>

                    {{-- Icon Gedung --}}
                    <div class="absolute -bottom-6 left-6 p-3 bg-white rounded-xl shadow-md">
                        <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="pt-10 px-6 pb-6 flex-1 flex flex-col">

                    {{-- Nama Cabang --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition">
                        {{ $branch->name }}
                    </h3>
                    <span
                        class="inline-flex mb-4 px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 w-fit">
                        Status: Aktif
                    </span>

                    {{-- Detail Info --}}
                    <div class="space-y-3 mt-2">
                        {{-- Alamat --}}
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="leading-relaxed">{{ Str::limit($branch->address, 60) }}</p>
                        </div>

                        {{-- Kontak --}}
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <p>{{ $branch->phone }}</p>
                        </div>
                    </div>

                </div>

                {{-- Footer: Actions (UPDATED STYLE) --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">

                    {{-- Kiri: ID --}}
                    <div class="text-xs text-gray-400 font-medium">
                        ID: #{{ $branch->id }}
                    </div>

                    {{-- Kanan: Action Icons --}}
                    <div class="flex items-center gap-2">
                        {{-- Edit Button --}}
                        <a href="{{ route('branches.edit', $branch) }}"
                            class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                            title="Edit Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        {{-- Delete Button (Trigger Modal) --}}
                        <button
                            x-on:click.prevent="deleteUrl = '{{ route('branches.destroy', $branch) }}'; branchName = '{{ addslashes($branch->name) }}'; $dispatch('open-modal', 'confirm-branch-deletion')"
                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                            title="Hapus Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
            @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-xl border border-dashed border-gray-300">
                <div class="bg-gray-50 p-4 rounded-full mb-3">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada Cabang</h3>
                <p class="text-gray-500 mt-1 mb-6">Tambahkan lokasi cabang bimbel Anda.</p>
                <a href="{{ route('branches.create') }}">
                    <x-primary-button>Tambah Cabang</x-primary-button>
                </a>
            </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $branches->links() }}
        </div>

        {{-- MODAL HAPUS --}}
        <x-modal name="confirm-branch-deletion" focusable>
            <form method="post" :action="deleteUrl" class="p-6">
                @csrf
                @method('DELETE')

                <div class="flex items-center gap-3 mb-4 text-red-600">
                    <div class="bg-red-100 p-2 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ __('Hapus Cabang?') }}
                    </h2>
                </div>

                <p class="mt-2 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus cabang <strong class="text-gray-900"
                        x-text="branchName"></strong>?
                    <br>Semua data yang terkait dengan cabang ini (Kelas, Transaksi, dll) mungkin akan terpengaruh.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button>
                        {{ __('Ya, Hapus Cabang') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>