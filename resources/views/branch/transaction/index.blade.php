@php
    $breadcrumbs = [
        'Keuangan' => null,
        'Riwayat Transaksi' => route('branch.transactions.index', $branch),
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Riwayat Transaksi</x-slot>

    {{-- Alpine (Live Search Logic) --}}
    <div x-data="{ 
            search: '{{ request('search') }}',
            isLoading: false,
            
            async performSearch() {
                this.isLoading = true;
                try {
                    const response = await fetch(`{{ route('branch.transactions.index', $branch) }}?search=${this.search}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    document.getElementById('transaction-list-container').innerHTML = html;
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            }
         }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Transaksi Masuk</h2>
                <div class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model.debounce.500ms="search"
                        x-init="$watch('search', value => performSearch())"
                        placeholder="Cari No. Invoice atau Nama Siswa..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200 shadow-sm">
                    
                    {{-- Spinner --}}
                    <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        style="display: none;">
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
            </div>

            {{-- Kanan: Info (No Create Button) --}}
            <div class="text-sm text-gray-500">
                <p>Pencatatan pembayaran dilakukan di menu <b>Data Siswa</b>.</p>
            </div>
        </div>

        {{-- SECTION: Data Table Container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
            id="transaction-list-container">
            @include('branch.transaction._list')
        </div>

    </div>
</x-app-layout>
