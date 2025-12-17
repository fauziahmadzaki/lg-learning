<x-app-layout :breadcrumbs="['Paket Bimbel' => null]">
    <x-slot name="pageTitle">Daftar Paket Belajar</x-slot>

    {{-- SETUP ALPINE JS: Gabungan Delete Modal + Tabs Filter --}}
    <div x-data="{ 
            deleteAction: '', 
            packageName: '', 
            activeTab: 'SEMUA' 
        }">

        {{-- Header & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">

            {{-- Kiri: Search --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Pilih Paket Belajar</h2>
                <div class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari nama paket atau jenjang..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200">
                </div>
            </div>

            {{-- Kanan: Tombol Tambah --}}
            <a href="{{ route('admin.packages.create') }}">
                <x-primary-button class="flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Paket Baru
                </x-primary-button>
            </a>
        </div>

        {{-- SECTION TABS NAVIGATION --}}
        <div class="mb-8 border-b border-gray-200">
            <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">

                {{-- Tab SEMUA --}}
                <button @click="activeTab = 'SEMUA'" :class="activeTab === 'SEMUA' 
                        ? 'border-indigo-500 text-indigo-600' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Semua Paket
                </button>

                {{-- Loop Tab Jenjang (SD, SMP, SMA, dll) --}}
                @foreach($grades as $gradeKey)
                <button @click="activeTab = '{{ $gradeKey }}'" :class="activeTab === '{{ $gradeKey }}' 
                            ? 'border-indigo-500 text-indigo-600' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Jenjang {{ $gradeKey }}
                </button>
                @endforeach
            </nav>
        </div>

        {{-- GRID PAKET --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($packages as $package)
            <div x-show="activeTab === 'SEMUA' || activeTab === '{{ $package->grade }}'"
                x-transition.opacity.duration.300ms
                class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

                {{-- Gambar Header (Aspect Video Fixed) --}}
                <div class="aspect-video w-full bg-gray-100 relative overflow-hidden">
                    @if($package->image)
                    <img src="{{ asset('storage/'.$package->image) }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                    {{-- Pattern Fallback --}}
                    <div
                        class="w-full h-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-4xl font-black opacity-80">
                        {{ substr($package->name, 0, 1) }}
                    </div>
                    @endif

                    {{-- BADGE KATEGORI --}}
                    <div class="absolute top-3 left-3">
                        @php $color = $package->badge_color; @endphp
                        <span
                            class="bg-{{ $color }}-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wide">
                            {{ $package->category }}
                        </span>
                    </div>

                    {{-- BADGE GRADE --}}
                    <div class="absolute bottom-3 left-3">
                        <span
                            class="bg-gray-900/60 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded border border-white/20">
                            {{ $package->grade }}
                        </span>
                    </div>

                    {{-- Badge Harga --}}
                    <div
                        class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow text-sm font-bold text-gray-800 border border-white/50">
                        Rp {{ number_format($package->price, 0, ',', '.') }}
                    </div>
                </div>

                {{-- Body Card --}}
                <div class="pt-5 px-6 pb-2 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h4
                            class="text-lg font-bold text-gray-900 leading-tight group-hover:text-indigo-600 transition">
                            {{ $package->name }}
                        </h4>
                    </div>

                    {{-- Info Singkat --}}
                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-4 border-b border-gray-100 pb-4">
                        <span class="flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded text-gray-600">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $package->branch->name }}
                        </span>
                        <span class="flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded text-gray-600">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $package->session_count }} Sesi
                        </span>
                    </div>

                    {{-- List Benefit --}}
                    <ul class="space-y-2 mb-4 flex-1">
                        @if($package->benefits)
                        @foreach(array_slice($package->benefits, 0, 3) as $benefit)
                        <li class="flex items-start text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $benefit }}
                        </li>
                        @endforeach
                        @if(count($package->benefits) > 3)
                        <li class="text-xs text-gray-400 pl-6 font-medium">+ {{ count($package->benefits) - 3 }}
                            keuntungan lainnya</li>
                        @endif
                        @else
                        <li class="text-sm text-gray-400 italic">Belum ada detail benefit</li>
                        @endif
                    </ul>
                </div>

                {{-- Footer: Actions (CONSISTENT STYLE) --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">

                    {{-- Kiri: ID --}}
                    <div class="text-xs text-gray-400 font-medium">
                        ID: #{{ $package->id }}
                    </div>

                    {{-- Kanan: Action Icons --}}
                    <div class="flex items-center gap-2">
                        {{-- Edit Button --}}
                        <a href="{{ route('admin.packages.edit', $package) }}"
                            class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                            title="Edit Paket">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        {{-- Delete Button (Trigger Modal) --}}
                        <button
                            x-on:click.prevent="deleteAction = '{{ route('admin.packages.destroy', $package) }}'; packageName = '{{ addslashes($package->name) }}'; $dispatch('open-modal', 'confirm-package-deletion')"
                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                            title="Hapus Paket">
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
            <div class="col-span-full p-10 text-center bg-white rounded-xl border border-dashed border-gray-300">
                <div class="bg-indigo-50 p-4 rounded-full mb-4 inline-block">
                    <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-gray-900 font-bold text-lg">Belum ada paket tersedia</h3>
                <p class="text-sm text-gray-500 mt-1 mb-6">Silakan tambahkan data paket baru untuk memulai.</p>
                <a href="{{ route('admin.packages.create') }}">
                    <x-primary-button>Buat Paket Pertama</x-primary-button>
                </a>
            </div>
            @endforelse

        </div>

        {{-- MODAL HAPUS --}}
        <x-modal name="confirm-package-deletion" focusable>
            <form method="post" :action="deleteAction" class="p-6">
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
                        {{ __('Hapus Paket Belajar?') }}
                    </h2>
                </div>

                <p class="mt-1 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus paket <strong class="text-gray-900"
                        x-text="packageName"></strong>?
                    <br><br>
                    <span class="text-red-500 text-xs font-bold uppercase">Peringatan:</span> Data yang dihapus tidak
                    dapat dikembalikan.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button>
                        {{ __('Ya, Hapus Paket') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>