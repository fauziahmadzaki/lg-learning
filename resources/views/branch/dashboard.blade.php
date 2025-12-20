@extends('layouts.branch')

@section('header', 'Overview Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Total Students -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Siswa</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</h3>
        </div>
        <div class="p-3 bg-blue-50 rounded-full text-blue-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
    </div>

    <!-- Card 2: Active Packages (Classes) -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Kelas / Paket Aktif</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $activePackages }}</h3>
        </div>
        <div class="p-3 bg-purple-50 rounded-full text-purple-600">
             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
    </div>

    <!-- Card 3: Monthly Income -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Pemasukan Bulan Ini</p>
            <h3 class="text-3xl font-bold text-green-600 mt-1">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
        </div>
        <div class="p-3 bg-green-50 rounded-full text-green-600">
             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
    <div class="text-gray-500 italic text-sm">Belum ada aktivitas yang dicatat.</div>
</div>
@endsection
