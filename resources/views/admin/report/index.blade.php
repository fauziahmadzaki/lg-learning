<x-app-layout>
    <div x-data="{ 
        period: '{{ request('period', 'this_month') }}',
        toggleCustom() {
            // Logic handled by backend/blade toggle, but here for interactivity if needed
        }
    }">
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan</h1>
                <p class="text-sm text-gray-500">
                    Periode: {{ $start->format('d M Y') }} s/d {{ $end->format('d M Y') }}
                </p>
            </div>
            
        </div>

        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                
                {{-- Period Selector --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Periode</label>
                    <select name="period" x-model="period" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="today">Hari Ini</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="this_year">Tahun Ini</option>
                        <option value="custom">Custom Tanggal</option>
                    </select>
                </div>

                {{-- Custom Date Range (Show if period == custom) --}}
                <div x-show="period === 'custom'" style="display: none;" class="md:col-span-2 grid grid-cols-2 gap-2">
                    <div>
                         <label class="block text-xs font-medium text-gray-700 mb-1">Dari</label>
                         <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                         <label class="block text-xs font-medium text-gray-700 mb-1">Sampai</label>
                         <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>

                {{-- Branch Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Cabang</label>
                    <select name="branch_id" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Package Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Paket</label>
                    <select name="package_id" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Paket</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" @selected(request('package_id') == $pkg->id)>
                                {{ $pkg->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
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

        {{-- Cards Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Total Income --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-indigo-100 flex items-center gap-4">
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Total Transactions --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-indigo-100 flex items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $transactionCount }}</p>
                </div>
            </div>

            {{-- Net Profit --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-indigo-100 flex items-center gap-4">
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bersih (Net Profit)</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Table Detail --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Rincian Transaksi {{ $start->format('d M') }} - {{ $end->format('d M') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Invoice</th>
                            <th class="px-6 py-3">Siswa</th>
                            <th class="px-6 py-3">Cabang</th>
                            <th class="px-6 py-3">Paket</th>
                            <th class="px-6 py-3 text-right">Nominal</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                {{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d M Y H:i') : $trx->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs">{{ $trx->invoice_code }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $trx->student?->name ?? 'Siswa Terhapus' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $trx->student?->branch?->name ?? 'Tanpa Cabang' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $trx->student?->package?->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-green-600">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold">{{ $trx->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                                Tidak ada data transaksi untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
