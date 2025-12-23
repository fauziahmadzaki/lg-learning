@php
$breadcrumbs = [
'Master Data' => null,
'Siswa' => route('admin.students.index'),
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Data Siswa</x-slot>

    <div x-data="{ 
            search: '{{ request('search') }}',
            branchId: '{{ request('branch_id') }}', 
            grade: '{{ request('grade') }}', 
            packageId: '{{ request('package_id') }}',
            isLoading: false,
            deleteUrl: '',
            deleteName: '',
            
            async performSearch() {
                this.isLoading = true;
                
                // Build Query Params with URLSearchParams
                const params = new URLSearchParams({
                    search: this.search,
                    branch_id: this.branchId,
                    grade: this.grade,
                    package_id: this.packageId
                });

                try {
                    const response = await fetch(`{{ route('admin.students.index') }}?${params.toString()}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    const html = await response.text();
                    document.getElementById('student-list-container').innerHTML = html;
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            }
         }"
        @trigger-delete-modal.window="deleteUrl = $event.detail.url; deleteName = $event.detail.name; $dispatch('open-modal', 'confirm-student-deletion')">

        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">

            {{-- Search Bar & Filters --}}
            <div class="flex flex-col gap-4 w-full">
                
                {{-- Row 1: Search --}}
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model.debounce.500ms="search"
                        x-init="$watch('search', value => performSearch())" placeholder="Cari nama, sekolah, atau email siswa..."
                        class="pl-10 pr-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm">
                    
                    {{-- Spinner --}}
                    <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-3 flex items-center" style="display: none;">
                        <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Row 2: Filters --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    {{-- Filter Cabang --}}
                    <x-inputs.select x-model="branchId" @change="performSearch()" class="block w-full rounded-lg text-sm shadow-sm">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </x-inputs.select>

                    {{-- Filter Grade --}}
                    <x-inputs.select x-model="grade" @change="performSearch()" class="block w-full rounded-lg text-sm shadow-sm">
                        <option value="">Semua Tingkatan</option>
                        @foreach($grades as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </x-inputs.select>

                    {{-- Filter Paket --}}
                    <x-inputs.select x-model="packageId" @change="performSearch()" class="block w-full rounded-lg text-sm shadow-sm">
                        <option value="">Semua Paket</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                        @endforeach
                    </x-inputs.select>
                </div>

            </div>

            {{-- Button --}}
            <a href="{{ route('admin.students.create') }}">
                <x-buttons.primary class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Siswa
                </x-buttons.primary>
            </a>
        </div>

        {{-- Container Tabel (Load Partial) --}}
        <div id="student-list-container">
            @include('admin.student.partials.table')
        </div>

        {{-- Modal Hapus --}}
        <x-ui.modal name="confirm-student-deletion" focusable>
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
                    <h2 class="text-lg font-bold text-gray-900">Hapus Data Siswa?</h2>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus <strong x-text="deleteName"></strong>? Data tagihan dan riwayat
                    pembayaran juga akan terhapus permanen.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <x-buttons.secondary x-on:click="$dispatch('close')">Batal</x-buttons.secondary>
                    <x-buttons.danger>Ya, Hapus</x-buttons.danger>
                </div>
            </form>
        </x-ui.modal>

    </div>
</x-app-layout>