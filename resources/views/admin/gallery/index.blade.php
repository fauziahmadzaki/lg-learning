@php
$breadcrumbs = [
    'Master Data' => null,
    'Galeri' => route('admin.contents.index'),
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Kelola Konten & Galeri</x-slot>

    <div class="py-2">
        
        {{-- Header & Actions (Matching Student Index Style) --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            
            {{-- Search Bar (Placeholder for visual consistency) --}}
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Cari konten..." disabled
                    class="pl-10 pr-10 block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm cursor-not-allowed">
            </div>

            {{-- Action Button --}}
            <a href="{{ route('admin.contents.create') }}">
                <x-primary-button class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Konten
                </x-primary-button>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-md shadow-sm border border-green-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-bold text-gray-600">Gambar</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Judul</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Kategori</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Status</th>
                            <th class="px-6 py-4 font-bold text-gray-600">Deskripsi</th>
                            <th class="px-6 py-4 text-center font-bold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contents as $content)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 align-middle">
                                <div class="h-16 w-24 rounded-lg overflow-hidden border border-gray-200 shadow-sm bg-gray-100">
                                    <img src="{{ $content->image_url }}" class="w-full h-full object-cover" alt="{{ $content->title }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($content->title) }}&background=random';">
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 align-middle">
                                {{ $content->title }}
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $content->type == 'Kegiatan' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-green-50 text-green-700 border border-green-100' }}">
                                    {{ $content->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                @if($content->is_carousel)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                                        Slide
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-400">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-gray-600">
                                <p class="truncate max-w-xs">{{ Str::limit($content->description, 60) }}</p>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.contents.edit', $content) }}" class="p-1.5 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-100 transition shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 font-medium">Belum ada konten galeri</p>
                                    <p class="text-xs text-gray-400 mt-1">Klik tombol tambah untuk mulai membuat konten</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
