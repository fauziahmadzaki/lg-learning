@php
    $breadcrumbs = [
        'Data Paket' => route('admin.packages.index'),
        $package->name => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Detail Paket: {{ $package->name }}</x-slot>

    <div class="space-y-6">
        
        {{-- Card 1: Informasi Utama & Tutor --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Info Paket --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $package->name }}</h2>
                        <div class="flex items-center gap-2 mt-2">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                Cabang: {{ $package->branch->name }}
                             </span>
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $package->category === 'PRIVATE' ? 'bg-purple-100 text-purple-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $package->category }}
                             </span>
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                {{ $package->packageCategory->name ?? 'Umum' }}
                             </span>
                        </div>
                    </div>
                     {{-- Edit Button --}}
                    <a href="{{ route('admin.packages.edit', $package) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="block text-xs text-gray-500 uppercase font-bold">Harga</span>
                        @if($package->duration < 30 && $package->duration > 0)
                            <span class="block text-lg font-bold text-gray-800">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-400">/ Hari</span>
                        @else
                            <span class="block text-lg font-bold text-gray-800">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-gray-400">/ Bulan</span>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="block text-xs text-gray-500 uppercase font-bold">Durasi</span>
                        @if($package->duration < 30 || $package->duration % 30 != 0)
                            <span class="block text-lg font-bold text-gray-800">{{ $package->duration }} Hari</span>
                            <span class="text-xs text-gray-400">Total Hari</span>
                        @else
                            <span class="block text-lg font-bold text-gray-800">{{ $package->duration / 30 }} Bulan</span>
                            <span class="text-xs text-gray-400">{{ $package->duration }} Hari</span>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="block text-xs text-gray-500 uppercase font-bold">Pertemuan</span>
                        <span class="block text-lg font-bold text-gray-800">{{ $package->session_count }}x</span>
                        <span class="text-xs text-gray-400">Per Minggu</span>
                    </div> 
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="block text-xs text-gray-500 uppercase font-bold">Total Siswa</span>
                        <span class="block text-lg font-bold text-gray-800">{{ $students->total() }}</span>
                        <span class="text-xs text-gray-400">Aktif & Non-Aktif</span>
                    </div>
                </div>

                <div class="mb-6 border-b border-gray-100 pb-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase mb-2">Deskripsi Paket</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $package->description ?? 'Tidak ada deskripsi untuk paket ini.' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-800 uppercase mb-2">Fasilitas / Benefits</h3>
                    <div class="flex flex-wrap gap-2">
                         @if($package->benefits)
                            @foreach($package->benefits as $benefit)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $benefit }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400 italic text-sm">Tidak ada data fasilitas.</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Tutor List --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Tutor Pengampu
                </h3>

                <div class="space-y-4">
                    @forelse($package->tutors as $tutor)
                        <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                @if($tutor->image)
                                    <img src="{{ asset('storage/' . $tutor->image) }}" 
                                         alt="{{ $tutor->user->name }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128';">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $tutor->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $tutor->jobs[0] ?? 'Tutor' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 italic bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            Belum ada tutor yang ditugaskan.
                        </div>
                    @endforelse
                </div>
                

            </div>
        </div>

        {{-- Card 2: Daftar Siswa --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Siswa Terdaftar</h3>
                        <div class="flex items-center gap-3 text-sm text-gray-500 mt-1">
                            <span>Total {{ $students->total() }} siswa</span>
                            <span class="text-gray-300">|</span>
                            <span>Total Tabungan: <span class="font-bold text-gray-800">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span></span>
                        </div>
                    </div>
                    
                    {{-- Status Filter --}}
                    <form method="GET" action="{{ route('admin.packages.show', $package) }}" class="flex items-center gap-2">
                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-200 text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Sekolah</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Saldo Tabungan</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-center">Aksi</th>
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
                                        <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                        <div class="text-xs text-gray-500">Joined: {{ $student->join_date ? $student->join_date->format('d/m/Y') : '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div>{{ $student->parent_phone }}</div>
                                <div class="text-xs text-gray-400">{{ $student->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $student->school }}</div>
                                <div class="text-xs text-gray-500">{{ $student->grade }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800">Rp {{ number_format($student->savings_balance, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($student->status == 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @elseif($student->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($student->status == 'finished')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Selesai</span>
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
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Belum ada siswa terdaftar pada paket ini.
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
