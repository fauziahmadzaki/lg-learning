<x-app-layout :breadcrumbs="['Laporan Keuangan' => route('branch.reports.index', $branch)]">
    <x-slot name="pageTitle">Laporan Keuangan - {{ $branch->name }}</x-slot>

    <div x-data="{ 
        period: '{{ request('period', 'this_month') }}',
        toggleCustom() {
            // Logic handled by backend/blade toggle
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
            <form method="GET" action="{{ route('branch.reports.index', $branch) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                {{-- Period Selector --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Periode</label>
                    <x-inputs.select name="period" x-model="period" class="w-full text-sm">
                        <option value="today">Hari Ini</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="this_year">Tahun Ini</option>
                        <option value="custom">Custom Tanggal</option>
                    </x-inputs.select>
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

                {{-- Package Filter --}}
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Paket</label>
                    <x-inputs.select name="package_id" class="w-full text-sm">
                        <option value="">Semua Paket</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" @selected(request('package_id') == $pkg->id)>
                                {{ $pkg->name }}
                            </option>
                        @endforeach
                    </x-inputs.select>
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            {{-- 1. Total Cash Masuk --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                <div class="p-3 bg-gray-100 rounded-lg text-gray-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                     <p class="text-xs text-gray-500 uppercase font-bold">Total Cash Masuk</p>
                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- 2. Pemasukan Bimbel (Earnings) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-indigo-100 flex items-center gap-4">
                 <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-bold">Pemasukan Bimbel</p>
                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($tuitionIncome, 0, ',', '.') }}</p>
                </div>
            </div>

             {{-- 3. Tabungan Masuk (Liability) --}}
             <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 flex items-center gap-4">
                 <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                   <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                     <p class="text-xs text-blue-500 uppercase font-bold">Tabungan Masuk</p>
                     <p class="text-xl font-bold text-gray-900">Rp {{ number_format($savingsIncome, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- 4. Total Penarikan (Withdraw) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-red-100 flex items-center gap-4">
                 <div class="p-3 bg-red-50 rounded-lg text-red-600">
                   <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </div>
                <div>
                    <p class="text-xs text-red-500 uppercase font-bold">Total Penarikan</p>
                     <p class="text-xl font-bold text-red-600">Rp {{ number_format($savingsWithdrawal, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Table Detail --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Rincian Transaksi {{ $start->format('d M') }} - {{ $end->format('d M') }}</h3>
            </div>
            <x-ui.table :headers="['Tanggal', 'Invoice', 'Tipe', 'Deskripsi', 'Siswa', 'Cabang', 'Paket', 'Nominal', 'Status']">
    @forelse($transactions as $trx)
    <x-ui.tr>
        <x-ui.td>
            {{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d M Y H:i') : $trx->created_at->format('d M Y') }}
        </x-ui.td>
        <x-ui.td class="font-mono text-xs">{{ $trx->invoice_code }}</x-ui.td>
        <x-ui.td>
            @if($trx->type == 'SAVINGS_DEPOSIT')
                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">DEPOSIT</span>
            @elseif($trx->type == 'SAVINGS_WITHDRAWAL')
                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold">PENARIKAN</span>
            @else
                <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs font-bold">SPP/BIMBEL</span>
            @endif
        </x-ui.td>
        <x-ui.td class="text-xs text-gray-500 italic max-w-xs truncate">
            {{ $trx->description ?? '-' }}
        </x-ui.td>
        <x-ui.td>
             <div class="font-medium text-gray-900">{{ $trx->student?->name ?? 'Siswa Terhapus' }}</div>
        </x-ui.td>
        <x-ui.td class="text-gray-600">
            {{ $trx->student?->branch?->name ?? 'Tanpa Cabang' }}
        </x-ui.td>
        <x-ui.td>
             <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $trx->student?->package?->name ?? '-' }}</span>
        </x-ui.td>
        <x-ui.td class="text-right font-medium text-green-600">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</x-ui.td>
        <x-ui.td>
            @if($trx->status == 'PAID')
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-bold">LUNAS</span>
            @elseif($trx->status == 'PENDING')
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">PENDING</span>
            @else
                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-bold">{{ $trx->status }}</span>
            @endif
        </x-ui.td>
    </x-ui.tr>
    @empty
    <x-ui.tr>
        <x-ui.td colspan="9" class="text-center py-10 text-gray-400">
            Tidak ada data transaksi untuk periode ini.
        </x-ui.td>
    </x-ui.tr>
    @endforelse
</x-ui.table>
        </div>
    </div>
</x-app-layout>
