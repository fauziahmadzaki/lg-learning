@php
    $breadcrumbs = [
        'Laporan & Log' => null,
        'Laporan Siswa' => route('admin.reports.students'),
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Laporan Data Siswa</x-slot>

    <div x-data>
        
        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                {{-- Branch Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Cabang</label>
                    <x-inputs.select name="branch_id" class="w-full text-sm">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </x-inputs.select>
                </div>

                {{-- Grade Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kelas / Tingkatan</label>
                    <x-inputs.select name="grade" class="w-full text-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade }}" @selected(request('grade') == $grade)>
                                {{ $grade }}
                            </option>
                        @endforeach
                    </x-inputs.select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 md:col-span-2">
                    <button type="submit" name="action" value="filter" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                        Filter
                    </button>
                    <button type="submit" name="action" value="export" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Excel
                    </button>
                </div>
            </form>
        </div>

        {{-- Table Detail --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Data Siswa</h3>
                <span class="text-xs text-gray-500">Total: {{ $students->total() }} Siswa</span>
            </div>
            <x-ui.table :headers="['Nama Siswa', 'Sekolah', 'Kelas', 'Cabang', 'Paket', 'Status', 'Bergabung']" :paginator="$students">
    @forelse($students as $student)
    <x-ui.tr>
        <x-ui.td class="font-medium text-gray-900">
            {{ $student->name }}
            <div class="text-xs text-gray-400">{{ $student->email }}</div>
        </x-ui.td>
        <x-ui.td>{{ $student->school }}</x-ui.td>
        <x-ui.td>{{ $student->grade }}</x-ui.td>
        <x-ui.td class="text-gray-600">
            {{ $student->branch?->name ?? 'Tanpa Cabang' }}
        </x-ui.td>
        <x-ui.td>
            <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $student->package?->name ?? '-' }}</span>
        </x-ui.td>
        <x-ui.td>
            @if($student->status == 'active')
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold">Aktif</span>
            @elseif($student->status == 'inactive')
                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-bold">Tidak Aktif</span>
            @elseif($student->status == 'pending')
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">Pending</span>
            @else
                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">{{ ucfirst($student->status) }}</span>
            @endif
        </x-ui.td>
        <x-ui.td class="text-xs text-gray-500">
            {{ $student->created_at->format('d M Y') }}
        </x-ui.td>
    </x-ui.tr>
    @empty
    <x-ui.tr>
        <x-ui.td colspan="7" class="text-center py-10 text-gray-400">
            Tidak ada data siswa ditemukan.
        </x-ui.td>
    </x-ui.tr>
    @endforelse
</x-ui.table>
        </div>
    </div>
</x-app-layout>
