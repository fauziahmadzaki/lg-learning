                    {{-- Table Heads (Optional: usually table header stays in index, only body refreshes, or whole table refreshes. 
                       Here I will refresh the WHOLE table content to keep it simple with pagination links if needed, 
                       or just the rows.
                       Based on StudentController, it likely refreshes the whole LIST container.
                       Let's check Student index again.
                       id="student-list-container". inside is @include('admin.student._list').
                       So _list should contain the TABLE or at least the TBODY?
                       In Student it likely contains the whole table to be safe.
                       Let's make _list contain the WHOLE table. --}}
                    
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
                    <div class="font-medium text-gray-800">{{ $transaction->package_name_snapshot ?? ($transaction->package->name ?? '-') }}</div>
                    <div class="font-bold text-indigo-600 mt-0.5">
                        Rp {{ number_format($transaction->total_amount ?? $transaction->amount, 0, ',', '.') }}
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
                        {{ $transaction->transaction_date ? $transaction->transaction_date->format('d M Y') : '-' }}
                    </div>
                    <div class="text-xs text-gray-400 pl-6">
                         {{ $transaction->transaction_date ? $transaction->transaction_date->format('H:i') . ' WIB' : '' }}
                    </div>
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
            {{-- Empty State --}}
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
