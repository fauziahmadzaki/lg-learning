@php
    $breadcrumbs = [
        'Daftar Cabang' => route('admin.branches.index'),
        $branch->name => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Detail Cabang: {{ $branch->name }}</x-slot>

    <div class="space-y-8">
        {{-- 1. Info Utama & Stats --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $branch->name }}</h2>
                    <div class="flex items-center text-gray-500 text-sm gap-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $branch->address }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $branch->phone ?? '-' }}
                        </span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.branches.edit', $branch) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 mr-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Cabang
                    </a>
                    
                    <a href="{{ route('branch.dashboard', $branch) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Kelola
                    </a>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-indigo-500 uppercase">Total Siswa</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ $branch->students_count }}</p>
                    </div>
                    <div class="bg-white p-2 rounded-lg text-indigo-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="bg-purple-50 p-4 rounded-xl border border-purple-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-purple-500 uppercase">Tutor Aktif</p>
                        <p class="text-2xl font-bold text-purple-700">{{ $branch->tutors_count }}</p>
                    </div>
                     <div class="bg-white p-2 rounded-lg text-purple-500 shadow-sm">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="bg-orange-50 p-4 rounded-xl border border-orange-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-orange-500 uppercase">Paket Tersedia</p>
                        <p class="text-2xl font-bold text-orange-700">{{ $branch->packages_count }}</p>
                    </div>
                    <div class="bg-white p-2 rounded-lg text-orange-500 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Daftar Tutor --}}
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Daftar Tutor ({{ $tutors->count() }})
            </h3>
            
            @if($tutors->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($tutors as $tutor)
                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-gray-100">
                                     @if($tutor->image)
                                        <img src="{{ asset('storage/' . $tutor->image) }}" class="w-full h-full object-cover">
                                     @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128" class="w-full h-full object-cover">
                                     @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-gray-800 truncate">{{ $tutor->user->name }}</h4>
                                    <p class="text-xs text-gray-500 truncate">{{ $tutor->jobs[0] ?? 'Pengajar' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 border border-dashed border-gray-300">
                    Belum ada tutor terdaftar di cabang ini.
                </div>
            @endif
        </div>

        {{-- 3. Daftar Paket --}}
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Paket Layanan
            </h3>
            @if($packages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($packages as $package)
                        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800 text-lg">{{ $package->name }}</h4>
                                <span class="text-xs font-bold px-2 py-1 bg-gray-100 rounded text-gray-600">{{ $package->category }}</span>
                            </div>
                            <div class="text-sm text-gray-500 mb-4">
                                {{ $package->session_count }} Sesi &bull; {{ $package->active_students_count ?? $package->students_count }} Siswa
                            </div>
                            <a href="{{ route('admin.packages.show', $package) }}" class="block text-center text-sm font-medium text-indigo-600 bg-indigo-50 py-2 rounded-lg hover:bg-indigo-100 transition">
                                Detail Paket
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                 <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 border border-dashed border-gray-300">
                    Belum ada paket tersedia di cabang ini.
                </div>
            @endif
        </div>

        {{-- 4. Daftar Siswa (Table) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Daftar Siswa ({{ $students->total() }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-200 text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Sekolah</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Paket</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $student->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->school }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $student->package->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($student->status == 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @elseif($student->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @else
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($student->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.students.show', $student) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                                Belum ada siswa di cabang ini.
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

    </div>
</x-app-layout>
