@php
$breadcrumbs = [
'Laporan & Log' => null,
'Log Aktivitas' => route('admin.activity-logs.index'),
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Log Aktivitas Sistem</x-slot>

    {{-- Setup Alpine Data --}}
    <div x-data="{ search: '{{ request('search') }}' }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Aktivitas Sistem</h2>

                <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari User, Aksi, atau Deskripsi..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200 shadow-sm">
                </form>
            </div>

            {{-- Kanan: Info Total (Opsional, karena tidak ada tombol tambah log) --}}
            <div class="hidden sm:block">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    Total: {{ $logs->total() }} Record
                </span>
            </div>
        </div>

        {{-- SECTION: Data Table Container --}}
        {{-- SECTION: Data Table Container --}}
        <x-ui.table :headers="['Waktu & Cabang', 'Aktor (User)',  'Deskripsi']" :paginator="$logs">
            @forelse ($logs as $log)
            <x-ui.tr>

                {{-- Kolom 1: Waktu & Cabang --}}
                <x-ui.td>
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-800">{{ $log->created_at->format('d M Y') }}</span>
                        <span class="text-xs text-gray-500">{{ $log->created_at->format('H:i') }} WIB</span>

                        <div class="mt-1">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $log->branch ? $log->branch->name : 'Pusat' }}
                            </span>
                        </div>
                    </div>
                </x-ui.td>

                {{-- Kolom 2: Aktor --}}
                <x-ui.td>
                    <div class="flex items-center gap-3">
                        <div
                            class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs uppercase">
                            {{ substr($log->user ? $log->user->name : 'S', 0, 2) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">
                                {{ $log->user ? $log->user->name : 'Sistem' }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $log->user ? $log->user->email : '-' }}</div>
                        </div>
                    </div>
                </x-ui.td>

                {{-- Kolom 3: Aksi (Badge) --}}

                {{-- Kolom 4: Deskripsi --}}
                <x-ui.td class="whitespace-normal min-w-[300px]">
                    <div class="text-gray-700 text-sm">
                        {{ $log->description }}
                    </div>
                    @if($log->subject_type)
                    <div class="text-xs text-gray-400 mt-1 font-mono">
                        Target: {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                    </div>
                    @endif
                </x-ui.td>




            </x-ui.tr>
            @empty
            <x-ui.tr>
                <x-ui.td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum ada Aktivitas</h3>
                        <p class="text-gray-500 mt-1 max-w-sm">
                            Belum ada riwayat perubahan data yang tercatat di sistem.
                        </p>
                    </div>
                </x-ui.td>
            </x-ui.tr>
            @endforelse
        </x-ui.table>

    </div>
</x-app-layout>