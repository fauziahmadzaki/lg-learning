@php
$breadcrumbs = [
'Keuangan' => null,
'Riwayat Transaksi' => route('admin.transactions.index'),
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Riwayat Transaksi</x-slot>

    {{-- Setup Alpine Data (Untuk fitur search atau modal filter nanti) --}}
    <div x-data="{ search: '{{ request('search') }}' }">

        {{-- SECTION: Header & Actions --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">

            {{-- Kiri: Search Bar --}}
            <div class="w-full sm:w-1/2">
                <h2 class="text-gray-800 font-bold text-lg hidden sm:block">Daftar Transaksi Masuk</h2>

                {{-- Form Search (Opsional, jika controller mendukung) --}}
                <form method="GET" action="{{ route('admin.transactions.index') }}" class="relative mt-2 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari No. Invoice atau Nama Siswa..."
                        class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 sm:text-sm transition duration-200 shadow-sm">
                </form>
            </div>

            {{-- Kanan: Tombol Tambah --}}
            <a href="{{ route('admin.transactions.create') }}">
                <x-primary-button class="flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Transaksi Baru
                </x-primary-button>
            </a>
        </div>

        {{-- SECTION: Data Table Container --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    {{-- Table Head --}}
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Invoice Info</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Siswa</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Paket & Harga</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs">Tanggal</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-center">Status</th>
                            <th class="px-6 py-4 font-semibold uppercase tracking-wider text-xs text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 group">

                            {{-- Kolom 1: Invoice --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-100 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <span
                                            class="block font-bold text-gray-800">{{ $transaction->invoice_code }}</span>
                                        <span class="text-xs text-gray-500">ID: #{{ $transaction->id }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom 2: Siswa --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $transaction->student->name }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->student->email }}</div>
                            </td>

                            {{-- Kolom 3: Paket --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $transaction->package_name_snapshot }}</div>
                                <div class="font-bold text-indigo-600 mt-0.5">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- Kolom 4: Tanggal --}}
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{-- {{ $transaction->transaction_date->format('d M Y') }} --}}
                                </div>
                                <div class="text-xs text-gray-400 pl-6">
                                    {{-- {{ $transaction->transaction_date->format('H:i') }} WIB
                                </div> --}}
                            </td>

                            {{-- Kolom 5: Status (Badges) --}}
                            <td class="px-6 py-4 text-center">
                                @if($transaction->status == 'PAID')
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    LUNAS
                                </span>
                                @elseif($transaction->status == 'PENDING')
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                    <svg class="w-3 h-3 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    PENDING
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    {{ $transaction->status }}
                                </span>
                                @endif
                            </td>

                            {{-- Kolom 6: Aksi --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors duration-200">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        {{-- Empty State (Mirip Cabang tapi Full Width) --}}
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-3">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada Transaksi</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Data transaksi pembayaran siswa akan muncul
                                        di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $transactions->links() }}
            </div>
            @endif

        </div>

    </div>
</x-app-layout>