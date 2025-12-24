<x-app-layout>
    <x-slot name="pageTitle">Ringkasan</x-slot>

    <div class="space-y-6">

        {{-- 1. WELCOME BANNER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-sm text-gray-500">Berikut adalah ringkasan aktivitas bimbel hari ini.</p>
            </div>
            <div class="hidden sm:block">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 mr-2 bg-green-400 rounded-full animate-pulse"></span>
                    Sistem Online
                </span>
            </div>
        </div>

        {{-- 2. STATS GRID (Real Data) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card 1: Total Cabang --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Cabang</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $totalBranches }}</h4>
                </div>
            </div>

            {{-- Card 2: Total Tutor --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Tutor Aktif</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ $activeTutors }}</h4>
                </div>
            </div>

            {{-- Card 3: Paket Terjual --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Jumlah Paket</p>
                    <h4 class="text-xl font-bold text-gray-800">{{ number_format($totalPackages) }}</h4>
                </div>
            </div>

            {{-- Card 4: Pendapatan (Bulan Ini) --}}
            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-center gap-4">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Pemasukan Bulan Ini</p>
                    <h4 class="text-xl font-bold text-gray-800">Rp {{ number_format($revenue, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        {{-- 3. CONTENT SECTION (Split Layout) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Bagian Kiri: Placeholder Grafik --}}
            {{-- Bagian Kiri: Grafik Omset --}}
            <div class="lg:col-span-2 border border-gray-200 rounded-xl p-6 bg-white shadow-sm flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-gray-900 font-bold text-lg">Statistik Pemasukan</h3>
                        <p class="text-sm text-gray-500">Grafik pemasukan 7 hari terakhir</p>
                    </div>
                </div>
                
                <div class="relative flex-1 w-full min-h-[300px]">
                    <canvas id="revenueChart"></canvas>
                </div>

                <!-- Load Chart.js from CDN -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('revenueChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: @json($chartLabels),
                                datasets: [{
                                    label: 'Pemasukan (Rp)',
                                    data: @json($chartValues),
                                    borderColor: '#4F46E5', 
                                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: '#4F46E5',
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        padding: 12,
                                        cornerRadius: 8,
                                        callbacks: {
                                            label: function(context) {
                                                let value = context.parsed.y;
                                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { borderDash: [2, 4], color: '#f3f4f6' },
                                        ticks: {
                                            callback: function(value) {
                                                return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value);
                                            },
                                            font: { size: 11 }
                                        }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { size: 11 } }
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>

            {{-- Bagian Kanan: Aktivitas Terbaru --}}
            <div class="border border-gray-100 rounded-xl p-4 bg-gray-50">
                <h3 class="text-gray-800 font-bold mb-4 text-sm uppercase tracking-wide">Aktivitas Terbaru</h3>

                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        @php
                            $dotColor = match($activity->action) {
                                'CREATE' => 'bg-green-500',
                                'UPDATE' => 'bg-blue-500', 
                                'DELETE' => 'bg-red-500',
                                default  => 'bg-gray-500'
                            };
                        @endphp
                        {{-- Item Loop --}}
                        <div class="flex gap-3">
                            <div class="mt-1">
                                <div class="w-2 h-2 rounded-full {{ $dotColor }}"></div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800 font-medium">
                                    <span class="font-bold">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="text-gray-600">{{ strtolower($activity->description) }}</span>
                                </p>
                                <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-sm text-gray-500 italic">Belum ada aktivitas tercatat.</p>
                        </div>
                    @endforelse
                </div>

                <a href="{{ route('admin.activity-logs.index') }}">
                    <button
                        class="w-full mt-6 py-2 text-xs font-medium text-gray-500 border border-gray-200 rounded-lg hover:bg-white hover:text-indigo-600 transition">
                        Lihat Semua Aktivitas
                    </button>
                </a>
            </div>
        </div>

        {{-- 4. QUICK ACTIONS --}}
        <div class="pt-4 border-t border-gray-100">
            <h3 class="text-gray-800 font-bold mb-4 text-sm uppercase tracking-wide">Akses Cepat</h3>
            <div class="flex gap-3 overflow-x-auto pb-2">
                <a href="{{ route('admin.branches.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-100 transition whitespace-nowrap">
                    + Tambah Cabang
                </a>
                <a href="{{ route('admin.tutors.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-100 transition whitespace-nowrap">
                    + Tambah Tutor
                </a>
                <a href="{{ route('admin.packages.create') }}"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition whitespace-nowrap">
                    + Buat Paket
                </a>
            </div>
        </div>

    </div>
</x-app-layout>