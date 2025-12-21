@php
    $breadcrumbs = [
        'Master Data' => null,
        'Jadwal Belajar' => route('admin.schedules.index'),
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Manajemen Jadwal</x-slot>

    <div class="space-y-6" x-data="{ showAddModal: false, showDeleteModal: false, deleteUrl: '' }">
        
        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Jadwal Belajar</h2>
                <p class="text-sm text-gray-500">Atur jadwal kelas mingguan untuk setiap cabang.</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Filter Branch (If many) --}}
                <form method="GET" class="flex items-center">
                    <select name="branch_id" onchange="this.form.submit()" class="text-sm border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 mr-2">
                        <option value="">-- Semua Cabang --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->code }} - {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <button @click="showAddModal = true" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Jadwal
                </button>
            </div>
        </div>

        {{-- Weekly Grid --}}
        <div class="overflow-x-auto pb-6">
            <div class="min-w-[1000px] grid grid-cols-7 gap-4">
                @php
                    $days = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                    $colors = ['monday' => 'blue', 'tuesday' => 'purple', 'wednesday' => 'indigo', 'thursday' => 'green', 'friday' => 'yellow', 'saturday' => 'red', 'sunday' => 'gray'];
                @endphp

                @foreach($days as $key => $label)
                    <div class="bg-gray-50 rounded-xl border border-gray-200 flex flex-col h-full min-h-[400px]">
                        {{-- Col Header --}}
                        <div class="p-3 border-b border-gray-200 bg-white rounded-t-xl text-center sticky top-0 z-10">
                            <h3 class="font-bold text-gray-800 uppercase text-xs tracking-wider">{{ $label }}</h3>
                        </div>

                        {{-- Col Body --}}
                        <div class="p-2 space-y-2 flex-1">
                            @foreach($weeklySchedules[$key] as $schedule)
                                <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition group relative border-l-4 border-l-{{ $colors[$key] }}-500">
                                    {{-- Time --}}
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
                                            {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                        </span>
                                        {{-- Delete Button (Hidden, shown on hover) --}}
                                        <button @click="showDeleteModal = true; deleteUrl = '{{ route('admin.schedules.destroy', $schedule->id) }}'" class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                    
                                    {{-- Package --}}
                                    <h4 class="font-bold text-gray-800 text-sm leading-tight mb-1">{{ $schedule->package->name ?? 'Unknown' }}</h4>
                                    
                                    <div class="flex justify-between items-center text-[10px] text-gray-400">
                                        <span>{{ $schedule->branch->name ?? '' }}</span>
                                        <span>Quota: {{ $schedule->quota }}</span>
                                    </div>
                                </div>
                            @endforeach

                            @if(count($weeklySchedules[$key]) === 0)
                                <div class="h-full flex items-center justify-center text-gray-300 text-xs italic">
                                    - Kosong -
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Add Modal --}}
        <div x-show="showAddModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;">
            <div class="min-h-screen px-4 text-center">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showAddModal = false"></div>

                <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl relative">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Tambah Jadwal Baru</h3>

                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-4">
                            {{-- Branch --}}
                            <div>
                                <x-input-label for="branch_id" value="Cabang" />
                                <select name="branch_id" id="branch_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Package --}}
                            <div>
                                <x-input-label for="package_id" value="Paket Belajar" />
                                <select name="package_id" id="package_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} ({{ $package->branch->code ?? 'All' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Day --}}
                            <div>
                                <x-input-label for="day_of_week" value="Hari" />
                                <select name="day_of_week" id="day_of_week" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach(['monday'=>'Senin', 'tuesday'=>'Selasa', 'wednesday'=>'Rabu', 'thursday'=>'Kamis', 'friday'=>'Jumat', 'saturday'=>'Sabtu', 'sunday'=>'Minggu'] as $val => $txt)
                                        <option value="{{ $val }}">{{ $txt }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Time --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_time" value="Jam Mulai" />
                                    <input type="time" name="start_time" id="start_time" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <x-input-label for="end_time" value="Jam Selesai" />
                                    <input type="time" name="end_time" id="end_time" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                            </div>

                            {{-- Quota --}}
                            <div>
                                <x-input-label for="quota" value="Kuota Siswa (Opsional)" />
                                <input type="number" name="quota" value="20" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                                Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Warning Modal --}}
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showDeleteModal" @click="showDeleteModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Jadwal?</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Data jadwal akan dihapus permanen. Apakah Anda yakin?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Hapus
                            </button>
                        </form>
                        <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
