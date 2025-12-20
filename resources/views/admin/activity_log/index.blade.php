@php
$breadcrumbs = [
'Dashboard' => route('admin.dashboard'),
'Log Aktivitas' => null,
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    {{-- Table Head --}}
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Waktu & Cabang</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Aktor (User)</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-center">Aksi</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Deskripsi</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Detail Perubahan</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 group">

                            {{-- Kolom 1: Waktu & Cabang --}}
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>

                            {{-- Kolom 2: Aktor --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs uppercase">
                                        {{ substr($log->user ? $log->user->name : 'S', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $log->user ? $log->user->name : 'Sistem' }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->user ? $log->user->email : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom 3: Aksi (Badge) --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @php
                                $badgeClass = match($log->action) {
                                'CREATE' => 'bg-green-100 text-green-700 border-green-200',
                                'UPDATE' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'DELETE' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-700 border-gray-200',
                                };
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>

                            {{-- Kolom 4: Deskripsi --}}
                            <td class="px-6 py-4">
                                <div class="text-gray-700 text-sm">
                                    {{ $log->description }}
                                </div>
                                @if($log->subject_type)
                                <div class="text-xs text-gray-400 mt-1 font-mono">
                                    Target: {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                </div>
                                @endif
                            </td>

                            {{-- Kolom 5: Detail Perubahan --}}
                            <td class="px-6 py-4 text-xs">
                                @if(!empty($log->properties))
                                <div
                                    class="bg-gray-50 p-2 rounded-lg border border-gray-200 max-h-32 overflow-y-auto w-64 space-y-1">
                                    @foreach($log->properties as $key => $change)
                                    <div class="border-b border-gray-100 last:border-0 pb-1 mb-1 last:mb-0 last:pb-0">
                                        <span
                                            class="font-semibold text-gray-600 block mb-0.5">{{ ucfirst($key) }}:</span>
                                        <div class="flex flex-wrap items-center gap-1">
                                            <span
                                                class="bg-red-50 text-red-600 px-1.5 py-0.5 rounded border border-red-100 line-through opacity-75">
                                                {{ Str::limit($change['from'] ?? '-', 15) }}
                                            </span>
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                            <span
                                                class="bg-green-50 text-green-700 px-1.5 py-0.5 rounded border border-green-100 font-medium">
                                                {{ Str::limit($change['to'] ?? '-', 15) }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <span class="text-gray-400 italic">- Tidak ada detail -</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada Aktivitas</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">
                                        Belum ada riwayat perubahan data yang tercatat di sistem.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $logs->withQueryString()->links() }}
            </div>
            @endif

        </div>

    </div>
</x-app-layout>