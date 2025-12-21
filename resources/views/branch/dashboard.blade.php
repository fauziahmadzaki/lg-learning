@php
    $breadcrumbs = [
        'Ringkasan' => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Ringkasan Dashboard - {{ $branch->name }}</x-slot>

    <div class="space-y-8">
        
        {{-- Welcome Banner for Tutor --}}
        @if(auth()->user()->role === 'tutor')
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h2>
                    <p class="text-sm text-gray-500">Selamat datang kembali di dashboard pengajar.</p>
                </div>
            </div>
            <div>
                <a href="{{ route('branch.profile', $branch) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Lihat Profil Saya
                </a>
            </div>
        </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Total Students -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 2: Active Packages (Classes) -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kelas Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $activePackages }}</h3>
                </div>
                <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>

            <!-- Card 3: Monthly Income -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Pemasukan Bulan Ini</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-1">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Schedule Section --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Jadwal Hari Ini</h3>
                <span class="text-xs font-medium bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                @if($todaysSchedules->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-center">
                            <thead class="bg-gray-50/50 text-gray-500 font-medium border-b border-gray-100">
                                <tr>
                                    <th class="py-3 px-4 w-32">Waktu</th>
                                    <th class="py-3 px-4 text-left">Kelas / Paket</th>
                                    <th class="py-3 px-4 text-left">Tutor Pengampu</th>
                                    <th class="py-3 px-4 w-24">Kuota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($todaysSchedules as $schedule)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-4 px-4 font-bold text-gray-700">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <div class="font-bold text-gray-800">{{ $schedule->package->name }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $schedule->package->category }} &bull; {{ $schedule->package->grade }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($schedule->package->tutors as $tutor)
                                                    <a href="{{ route('branch.profile', $branch) }}" class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-indigo-50 text-indigo-700 text-xs font-medium hover:bg-indigo-100 transition">
                                                        @if($tutor->image)
                                                            <img src="{{ asset('storage/' . $tutor->image) }}" class="w-4 h-4 rounded-full object-cover">
                                                        @else
                                                            <div class="w-4 h-4 rounded-full bg-indigo-200 flex items-center justify-center text-[8px] font-bold text-indigo-700">
                                                                {{ substr($tutor->user->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        {{ explode(' ', $tutor->user->name)[0] }}
                                                    </a>
                                                @empty
                                                    <span class="text-xs text-gray-400 italic">Belum ada tutor</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold {{ $schedule->quota > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $schedule->quota }} Siswa
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white border border-gray-200 text-gray-400 mb-3 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-900 font-medium">Tidak ada jadwal kelas hari ini</p>
                        <p class="text-xs text-gray-500 mt-1">Silakan cek menu "Jadwal Belajar" untuk hari lain.</p>
                    </div>
                @endif
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('branch.schedules.index', $branch) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center gap-1">
                    Lihat Jadwal Lengkap <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
{{-- Active Classes / Packages Section --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Kelas Diampu (Aktif)</h3>
                <a href="{{ route('branch.courses.index', $branch) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center gap-1">
                    Lihat Semua <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            @if($packages->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($packages as $package)
                        <a href="{{ route('branch.courses.show', [$branch, $package]) }}" 
                           class="group block bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md hover:border-indigo-300 transition-all duration-300">
                            
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs font-bold">
                                    {{ $package->active_students_count }} Siswa
                                </span>
                            </div>

                            <h4 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition-colors mb-1 truncate">
                                {{ $package->name }}
                            </h4>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-1">
                                {{ $package->category ?? 'General' }} &bull; {{ $package->session_count }} Sesi
                            </p>

                            <div class="flex items-center text-sm font-medium text-indigo-600 mt-2">
                                Detail Kelas
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada kelas aktif di cabang ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
