@extends('layouts.branch')

@section('header')
<div class="flex items-center gap-4">
    <a href="{{ route('branch.courses.index', $branch) }}" class="text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $package->name }}</h1>
        <p class="text-sm text-gray-500">Daftar Siswa Terdaftar</p>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak Wali</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sekolah / Kelas</th>
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
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
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
@endsection
