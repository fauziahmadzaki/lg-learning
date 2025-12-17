<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }} #{{ $transaction->invoice_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- STATUS BANNER --}}
            <div class="mb-6 text-center">
                @if($transaction->status == 'PAID')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Pembayaran Berhasil!</strong>
                    <span class="block sm:inline">Terima kasih, pembayaran Anda telah kami terima.</span>
                </div>
                @elseif($transaction->status == 'PENDING')
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Menunggu Pembayaran!</strong>
                    <span class="block sm:inline">Silakan selesaikan pembayaran Anda sebelum waktu habis.</span>
                </div>
                @elseif($transaction->status == 'EXPIRED')
                <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Kedaluwarsa!</strong>
                    <span class="block sm:inline">Invoice ini sudah tidak berlaku. Silakan buat transaksi baru.</span>
                </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                {{-- HEADER INVOICE --}}
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Total Tagihan</p>
                        <p class="text-3xl font-bold text-gray-800">Rp
                            {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span
                            class="px-3 py-1 text-sm font-bold rounded-full 
                            {{ $transaction->status == 'PAID' ? 'bg-green-100 text-green-800' : 
                               ($transaction->status == 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $transaction->status }}
                        </span>
                    </div>
                </div>

                {{-- DETAIL INFO --}}
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-gray-500 text-sm font-bold uppercase mb-2">Informasi Siswa</h3>
                        <p class="font-medium text-gray-900">{{ $transaction->student->name }}</p>
                        <p class="text-gray-600 text-sm">{{ $transaction->student->email }}</p>
                        <p class="text-gray-600 text-sm">{{ $transaction->student->parent_phone }}</p>
                    </div>

                    <div>
                        <h3 class="text-gray-500 text-sm font-bold uppercase mb-2">Detail Paket</h3>
                        <p class="font-medium text-gray-900">{{ $transaction->package_name_snapshot }}</p>
                        <p class="text-gray-600 text-sm">Invoice: {{ $transaction->invoice_code }}</p>
                        {{-- <p class="text-gray-600 text-sm">Tgl: {{ $transaction->transaction_date->format('d M Y H:i') }}
                        --}}
                        </p>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('transactions.index') }}"
                        class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        &larr; Kembali ke Riwayat
                    </a>

                    @if($transaction->status == 'PENDING' && $transaction->payment_url)
                    <a href="{{ $transaction->payment_url }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Bayar Sekarang &rarr;
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>