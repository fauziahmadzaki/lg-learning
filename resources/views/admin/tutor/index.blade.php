<x-app-layout :breadcrumbs="['Manajemen Tutor' => null]">
    <x-slot name="pageTitle">Data Pengajar</x-slot>
    <div x-data="{ 
            deleteUrl: '', 
            tutorName: '',
            search: '{{ request('search') }}',
            branchId: '{{ request('branch_id') }}',
            job: '{{ request('job') }}',
            isLoading: false,

            async performSearch() {
                this.isLoading = true;
                
                const params = new URLSearchParams({
                    search: this.search,
                    branch_id: this.branchId,
                    job: this.job
                });

                try {
                    const response = await fetch(`{{ route('admin.tutors.index') }}?${params.toString()}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    document.getElementById('tutor-list-container').innerHTML = html;
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    this.isLoading = false;
                }
            }
        }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col gap-4 mb-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-gray-800 font-bold text-lg">Daftar Semua Tutor</h2>
                
                {{-- Tombol Tambah --}}
                <a href="{{ route('admin.tutors.create') }}">
                    <x-primary-button class="flex items-center gap-2 shadow-lg shadow-indigo-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Tutor
                    </x-primary-button>
                </a>
            </div>

            {{-- Row: Search & Filters --}}
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                
                {{-- Search Bar (Col-Span 6) --}}
                <div class="sm:col-span-6 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model.debounce.500ms="search"
                        x-init="$watch('search', value => performSearch())"
                        placeholder="Cari nama atau email..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm shadow-sm">
                    
                    {{-- Spinner --}}
                    <div x-show="isLoading" class="absolute inset-y-0 right-0 pr-3 flex items-center" style="display: none;">
                        <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Filter Cabang (Col-Span 3) --}}
                <div class="sm:col-span-3">
                    <select x-model="branchId" @change="performSearch()" 
                        class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Keahlian/Job (Col-Span 3) --}}
                <div class="sm:col-span-3">
                    <select x-model="job" @change="performSearch()" 
                        class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="">Semua Keahlian</option>
                        @foreach($allJobs as $jobItem)
                            <option value="{{ $jobItem }}">{{ $jobItem }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- SECTION: Grid Card --}}
        <div id="tutor-list-container">
            @include('admin.tutor._list')
        </div>

        {{-- MODAL HAPUS --}}
        <x-modal name="confirm-tutor-deletion" focusable>
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
                        {{ __('Hapus Data Tutor?') }}
                    </h2>
                </div>

                <p class="mt-1 text-sm text-gray-600">
                    Apakah Anda yakin ingin menghapus tutor <strong class="text-gray-900" x-text="tutorName"></strong>?
                    <br><br>
                    <span class="text-red-500 text-xs font-bold uppercase">Peringatan:</span> Akun login, foto profil,
                    dan riwayat pekerjaan tutor ini akan dihapus permanen dari sistem.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button>
                        {{ __('Ya, Hapus Tutor') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>