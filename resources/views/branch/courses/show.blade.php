@php
    $breadcrumbs = [
        'Kelas' => route('branch.courses.index', $branch),
        $package->name => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Detail Kelas: {{ $package->name }}</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header Info Section inside the card --}}
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Daftar Siswa</h2>
                <div class="flex items-center gap-3 text-sm text-gray-500 mt-1">
                    <span>Total {{ $students->total() }} siswa</span>
                    <span class="text-gray-300">|</span>
                    <span>Total Tabungan: <span class="font-bold text-gray-800">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span></span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                 {{-- Status Filter --}}
                 <form method="GET" action="{{ route('branch.courses.show', [$branch, $package]) }}" class="flex items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Selesai</option>
                    </select>
                 </form>

                 <div class="flex items-center gap-2">
                     <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                        {{ $package->session_count }} Sesi / Minggu
                     </span>
                     <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $package->category == 'PRIVATE' ? 'bg-purple-100 text-purple-700' : 'bg-pink-100 text-pink-700' }}">
                        {{ $package->category }}
                     </span>
                 </div>
            </div>
        </div>

        <div class="px-6 pb-6 mt-[-10px]">
            <h3 class="text-sm font-bold text-gray-800 uppercase mb-2">Deskripsi Kelas</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $package->description ?? 'Tidak ada deskripsi untuk kelas ini.' }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak Wali</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sekolah / Kelas</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Tabungan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $student->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $student->parent_phone }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $student->school }}</div>
                            <div class="text-xs text-gray-500">{{ $student->grade }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800">Rp {{ number_format($student->savings_balance, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $student->join_date ? $student->join_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($student->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @elseif($student->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($student->status == 'finished')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Selesai
                                </span>
                            @else
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst(strtolower($student->status)) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('branch.students.show', [$branch, $student]) }}" class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail & Tagihan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada siswa yang mendaftar di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($students->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
