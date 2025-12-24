@php
$breadcrumbs = [
'Laporan & Log' => null,
'Log Aktivitas' => route('admin.activity-logs.index'),
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Log Aktivitas Sistem</x-slot>

    {{-- Setup Alpine Data --}}
    <div x-data="{ 
        search: '{{ request('search') }}',
        isLoading: false,
        
        async performSearch() {
            this.isLoading = true;
            try {
                const params = new URLSearchParams({ 
                    search: this.search || '' 
                });
                
                const response = await fetch('{{ route('admin.activity-logs.index', [], false) }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('log-table-container').innerHTML = html;
                }
            } catch (error) {
                console.error('Search failed:', error);
            } finally {
                this.isLoading = false;
            }
        } 
    }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Aktivitas Sistem</h2>

                <div class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           x-model="search" 
                           @input.debounce.500ms="performSearch"
                           placeholder="Cari User, Aksi, atau Deskripsi..."
                           class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200 shadow-sm">
                    
                    {{-- Loading Indicator --}}
                    <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-3 flex items-center" style="display: none;">
                         <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Kanan: Info Total --}}
            <div class="hidden sm:block">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    Auto Search Active
                </span>
            </div>
        </div>

        {{-- SECTION: Data Table Container --}}
        <div id="log-table-container">
             @include('admin.activity_log.partials.table')
        </div>

    </div>
</x-app-layout>