<x-landing-layout>
    <div class="h-20 bg-white"></div>

    <section class="py-20 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="bg-gray-900 px-8 py-6 text-center">
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Invoice Code</div>
                <div class="text-xl font-mono text-white font-bold">{{ $transaction->invoice_code }}</div>
            </div>

            {{-- Body --}}
            <div class="p-8">
                <div class="text-center mb-8">
                    <p class="text-gray-500 mb-2">Total Pembayaran</p>
                    <h2 class="text-4xl font-extrabold text-orange-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50">
                        <span class="text-gray-500">Siswa</span>
                        <span class="font-bold text-gray-900">{{ $transaction->student->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50">
                        <span class="text-gray-500">Paket</span>
                        <span class="font-bold text-gray-900">{{ $transaction->student->package->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm py-2 border-b border-gray-50">
                        <span class="text-gray-500">Siklus Tagihan</span>
                        <span class="font-bold text-gray-900 capitalize">{{ $transaction->student->billing_cycle }}</span>
                    </div>
                </div>

                {{-- Status Logic --}}
                @if($transaction->status === 'PAID')
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
                        <p class="text-gray-500 mb-6">Terima kasih, akun siswa telah aktif.</p>
                        
                        <a href="{{ route('home') }}" class="inline-block w-full py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg mb-3">
                            Kembali ke Beranda
                        </a>
                        
                        {{-- Link ke Portal Siswa --}}
                        <a href="{{ route('student.portal.index', $transaction->student->access_token) }}" class="block w-full py-4 bg-white border border-gray-200 text-indigo-600 font-bold rounded-xl text-center hover:bg-gray-50 transition">
                            Buka Portal Siswa (Riwayat & Tagihan) 
                        </a>
                    </div>
                @elseif($transaction->status === 'EXPIRED')
                     <div class="text-center">
                         <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Tagihan Kadaluarsa</h3>
                        <p class="text-gray-500 mb-6">Silakan lakukan pendaftaran ulang.</p>
                         <a href="{{ route('packages') }}" class="inline-block w-full py-4 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg">
                            Daftar Ulang
                        </a>
                     </div>
                @else
                    {{-- PENDING --}}
                    <div class="text-center space-y-3">
                         <a href="{{ $transaction->payment_url }}" class="block w-full py-4 bg-orange-500 text-white font-bold rounded-xl text-center shadow-lg hover:bg-orange-600 hover:scale-[1.02] transition-all duration-300">
                            Lanjutkan Pembayaran
                        </a>
                        <p class="text-sm text-gray-400">
                            Menunggu pembayaran. Jika sudah membayar, status akan otomatis terupdate.
                        </p>
                        
                         {{-- Link ke Portal Siswa (Even Pending) --}}
                        <a href="{{ route('student.portal.index', $transaction->student->access_token) }}" class="block text-indigo-600 font-bold hover:underline mt-4">
                             Akses Portal Siswa
                        </a>

                        <a href="{{ route('home') }}" class="inline-block text-gray-500 font-medium hover:text-gray-700 text-xs mt-2">Kembali ke home</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-landing-layout>
