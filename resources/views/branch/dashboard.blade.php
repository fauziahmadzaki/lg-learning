@php
    $breadcrumbs = [
        'Ringkasan' => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Ringkasan Dashboard - {{ $branch->name }}</x-slot>

    <div class="space-y-8">
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
                            <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-200">
                                <tr>
                                    <th class="py-3 px-3">Jam</th>
                                    <th class="py-3 px-3 text-left">Kelas/Paket</th>
                                    <th class="py-3 px-3">Kuota</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($todaysSchedules as $schedule)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-3 font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td class="py-4 px-3 text-left">
                                            <div class="font-semibold text-gray-800">{{ $schedule->package->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ ucfirst($schedule->day_of_week) }}</div>
                                        </td>
                                        <td class="py-4 px-3">
                                            <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-bold">
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
                        <p class="text-xs text-gray-500 mt-1">Silakan cek menu "Kelas & Jadwal" untuk hari lain.</p>
                    </div>
                @endif
            </div>

             <div class="mt-4 text-center">
                <a href="{{ route('branch.courses.index', $branch) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center gap-1">
                    Lihat Semua Kelas <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
