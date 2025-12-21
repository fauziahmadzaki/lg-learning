@php
    $breadcrumbs = [
        'Master Data' => null,
        'Paket Belajar' => route('admin.packages.index'),
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Daftar Paket Belajar</x-slot>

    {{-- SETUP ALPINE JS: Gabungan Delete Modal + Tabs Filter --}}
    {{-- SETUP ALPINE JS: Gabungan Delete Modal + Tabs Filter --}}
    <div x-data="{ 
            deleteAction: '', 
            packageName: '', 
            activeTab: 'SEMUA',
            search: '{{ request('search') }}',
            category: '{{ request('category') }}', // State filter kategori
            isLoading: false,

            async performSearch() {
                this.isLoading = true;
                
                const params = new URLSearchParams({
                    search: this.search,
                    category: this.category
                });

                try {
                    const response = await fetch(`{{ route('admin.packages.index') }}?${params.toString()}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    const container = document.getElementById('package-list-container');
                    container.innerHTML = html;
                    
                    // Re-initialize Alpine for the new content (for x-show tabs)
                    if (window.Alpine) {
                        Alpine.initTree(container);
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            }
        }">

        {{-- Header & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">

            {{-- Kiri: Search --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Pilih Paket Belajar</h2>
                <div class="flex gap-3 mt-2 max-w-2xl">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model.debounce.500ms="search"
                            x-init="$watch('search', value => performSearch())" 
                            placeholder="Cari nama paket atau jenjang..."
                            class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200">
                        
                        {{-- Spinner --}}
                        <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-3 flex items-center" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- FILTER KATEGORI --}}
                    <div class="w-40">
                        <select x-model="category" @change="performSearch()"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Kategori</option>
                            <option value="PRIVATE">Private</option>
                            <option value="ROMBEL">Rombel</option>
                        </select>
                    </div>
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

                {{-- Loop Tab Jenjang (Dynamic Categories) --}}
                @foreach($grades as $id => $name)
                <button @click="activeTab = '{{ $id }}'" :class="activeTab == '{{ $id }}' 
                            ? 'border-indigo-500 text-indigo-600' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    {{ $name }}
                </button>
                @endforeach
            </nav>
        </div>

        {{-- GRID PAKET (Container) --}}
        <div id="package-list-container">
            @include('admin.package._list')
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