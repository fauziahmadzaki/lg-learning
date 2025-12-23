@php
    $breadcrumbs = [
        'Manajemen Cabang' => null,
        'Kelas & Paket' => route('branch.courses.index', $branch),
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Daftar Kelas - {{ $branch->name }}</x-slot>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Paket Belajar Aktif</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola data kelas dan lihat siswa yang terdaftar di dalamnya.
                </p>
            </div>
            <a href="{{ route('branch.packages.create', $branch) }}">
                <x-buttons.primary class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Paket
                </x-buttons.primary>
            </a>
        </div>

        {{-- Cek Data Kosong --}}
        @if($packages->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <div class="inline-flex p-4 rounded-full bg-indigo-50 text-indigo-200 mb-4">
                     <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum ada Paket Belajar</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto">
                    Anda belum membuat paket belajar untuk cabang ini. Silakan buat paket baru untuk mulai menerima pendaftaran siswa.
                </p>
                <div class="mt-6">
                    <a href="{{ route('branch.packages.create', $branch) }}">
                         <x-buttons.secondary>Buat Paket Pertama</x-buttons.secondary>
                    </a>
                </div>
            </div>
        @else
            {{-- Grid Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($packages as $package)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 flex flex-col h-full group">
                    <!-- Header / Image Placeholder -->
                    <div class="h-32 bg-gray-100 rounded-t-xl flex items-center justify-center relative overflow-hidden group-hover:bg-gray-200 transition">
                        @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 font-bold text-4xl select-none">{{ substr($package->name, 0, 1) }}</span>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold shadow-sm text-gray-700 border border-gray-100">
                                {{ $package->packageCategory->name ?? '-' }}
                            </span>
                        </div>
                    </div>
            
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-3">
                            <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider 
                                {{ $package->category === 'PRIVATE' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $package->category }}
                            </span>
                            <div class="flex items-center text-xs text-gray-500 font-medium">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                {{ $package->student_count }} Siswa
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-2 leading-tight group-hover:text-indigo-600 transition">{{ $package->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                            {{ $package->description ? Str::limit($package->description, 80) : 'Tidak ada deskripsi tambahan.' }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-sm">
                                <span class="block text-gray-400 text-xs uppercase tracking-wide">Biaya</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex gap-2">
                                {{-- Edit Button Removed as per request --}}
                                <a href="{{ route('branch.courses.show', [$branch, $package]) }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition shadow-sm">
                                    Lihat Siswa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $packages->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
