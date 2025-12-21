<x-landing-layout>
    <div class="h-16 bg-white shadow-sm absolute top-0 w-full z-10"></div> {{-- Spacer for Fixed Nav if any --}}

    <div class="min-h-screen bg-gray-50 pt-20 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto space-y-6">

            {{-- 1. Profile Header (Card) --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="px-6 pb-6 text-center relative">
                    <div class="-mt-12 mb-3 inline-block">
                        <div class="w-24 h-24 rounded-full bg-white p-1.5 shadow-md mx-auto">
                            <div class="w-full h-full rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600 uppercase">
                                {{ substr($student->name, 0, 2) }}
                            </div>
                        </div>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $student->name }}</h1>
                    <div class="text-sm text-gray-500 mt-1">
                        <div class="flex items-center justify-center gap-1 font-medium">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $student->branch->name ?? 'Cabang Pusat' }}
                        </div>
                        <p class="text-xs text-gray-400 max-w-xs mx-auto mt-0.5">
                            {{ $student->branch->address ?? '' }}
                        </p>
                    </div>

                    <div class="mt-4 flex justify-center gap-2 mb-4">
                         @if($student->status == 'active')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase rounded-full">Siswa Aktif</span>
                         @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase rounded-full">Tidak Aktif</span>
                         @endif
                         <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase rounded-full">{{ $student->package->name ?? 'No Package' }}</span>
                    </div>

                     {{-- Tombol Lihat Jadwal (Future Feature) --}}
                     <button onclick="alert('Fitur Jadwal akan segera hadir! Silakan hubungi admin cabang untuk info jadwal.')" class="w-full sm:w-auto px-6 py-2 bg-orange-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-600 transition flex items-center justify-center gap-2 mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Lihat Jadwal Belajar
                     </button>
                </div>
            </div>

            {{-- 2. Menu Tabs (Accordion / Stacked Cards) --}}
            <div x-data="{ activeTab: 'bills' }" class="space-y-4">
                
                {{-- Tab Buttons --}}
                <div class="flex p-1 bg-white rounded-xl shadow-sm border border-gray-200">
                    <button @click="activeTab = 'bills'" 
                        :class="activeTab === 'bills' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2 text-sm font-bold rounded-lg transition-all duration-200">
                        Tagihan
                         @php $unpaidCount = $student->bills->where('status', '!=', 'PAID')->count(); @endphp
                        @if($unpaidCount > 0)
                            <span class="ml-1 bg-red-500 text-white px-1.5 py-0.5 rounded-full text-[10px]">{{ $unpaidCount }}</span>
                        @endif
                    </button>
                    <button @click="activeTab = 'history'" 
                        :class="activeTab === 'history' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2 text-sm font-bold rounded-lg transition-all duration-200">
                        Riwayat
                    </button>
                    <button @click="activeTab = 'profile'" 
                        :class="activeTab === 'profile' ? 'bg-indigo-600 text-white shadow-md' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 py-2 text-sm font-bold rounded-lg transition-all duration-200">
                        Profil
                    </button>
                </div>

                {{-- Tab Content: Bill --}}
                <div x-show="activeTab === 'bills'" x-transition.opacity>
                    @if($student->status === 'finished')
                        {{-- Finished State --}}
                        <div class="bg-indigo-50 p-8 rounded-xl shadow-sm text-center border border-indigo-100 mb-6">
                            <div class="w-16 h-16 bg-white p-2 rounded-full mx-auto mb-4 shadow-sm relative">
                                <div class="w-full h-full bg-indigo-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="absolute -top-1 -right-1 bg-yellow-400 rounded-full p-1 border-2 border-white">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Program Selesai!</h3>
                            <p class="text-gray-600 mt-2 max-w-sm mx-auto">
                                Selamat! Ananda <strong>{{ $student->name }}</strong> telah menyelesaikan program belajar <strong>{{ $student->package->name ?? '' }}</strong>.
                            </p>
                        </div>

                        {{-- Still show bills if any UNPAID exist, just in case --}}
                        @if($student->bills->where('status', '!=', 'PAID')->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-500 uppercase mb-3 text-center">Tunggakan Tersisa</h4>
                                @foreach($student->bills->where('status', '!=', 'PAID') as $bill)
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-red-500 mb-3 opacity-75 grayscale hover:grayscale-0 transition">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-gray-800">{{ $bill->title }}</h3>
                                                <p class="text-xs text-gray-500 mt-1">Jatuh Tempo: {{ $bill->due_date->format('d M Y') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-red-600">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                                                <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold uppercase">{{ $bill->status }}</span>
                                            </div>
                                        </div>
                                        {{-- Action Pay --}}
                                        <div class="mt-3 pt-3 border-t border-gray-100 text-right">
                                            @if($bill->transaction && $bill->transaction->payment_url)
                                                <a href="{{ $bill->transaction->payment_url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center justify-end gap-1">
                                                    Bayar Sekarang &rarr;
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Link pembayaran belum tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                           {{-- If no bills, show nothing more or a history prompt --}}
                           <p class="text-center text-xs text-gray-400 mt-4">Semua administrasi telah lunas.</p> 
                        @endif

                    @elseif($student->bills->where('status', '!=', 'PAID')->count() > 0)
                        <div class="space-y-3">
                            @foreach($student->bills->where('status', '!=', 'PAID') as $bill)
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-red-500">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-gray-800">{{ $bill->title }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">Jatuh Tempo: {{ $bill->due_date->format('d M Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-red-600">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                                            <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold uppercase">{{ $bill->status }}</span>
                                        </div>
                                    </div>
                                    {{-- Action Pay --}}
                                    <div class="mt-3 pt-3 border-t border-gray-100 text-right">
                                        @if($bill->transaction && $bill->transaction->payment_url)
                                            <a href="{{ $bill->transaction->payment_url }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center justify-end gap-1">
                                                Bayar Sekarang &rarr;
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Link pembayaran belum tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-100">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">Tidak Ada Tagihan</h3>
                            <p class="text-sm text-gray-500">Semua administrasi aman terkendali 😎</p>
                            @if($student->status == 'active')
                                <p class="text-xs text-indigo-500 mt-2">Tagihan selanjutnya: {{ $student->next_billing_date ? $student->next_billing_date->format('d M Y') : '-' }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Content: History --}}
                <div x-show="activeTab === 'history'" x-transition.opacity style="display: none;">
                     <div class="space-y-3">
                        @foreach($student->transactions as $trx)
                             <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-mono text-gray-500">{{ $trx->invoice_code }}</span>
                                    @if($trx->status == 'PAID')
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-bold">LUNAS</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-[10px] font-bold">{{ $trx->status }}</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-sm text-gray-600">{{ $trx->transaction_date->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $trx->payment_method ?? 'Unknown Method' }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</p>
                                </div>
                             </div>
                        @endforeach
                     </div>
                </div>

                {{-- Content: Profile --}}
                <div x-show="activeTab === 'profile'" x-transition.opacity style="display: none;">
                     <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Informasi Kontak</p>
                            <div class="mt-2 space-y-2">
                                <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                                    <span class="text-gray-500">Email</span>
                                    <span class="font-medium">{{ $student->email }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                                    <span class="text-gray-500">No HP</span>
                                    <span class="font-medium">{{ $student->phone }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                                    <span class="text-gray-500">Ortu</span>
                                    <span class="font-medium">{{ $student->parent_phone }}</span>
                                </div>
                            </div>
                        </div>

                         <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Sekolah</p>
                            <div class="mt-2 space-y-2">
                                <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                                    <span class="text-gray-500">Asal Sekolah</span>
                                    <span class="font-medium">{{ $student->school ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-b border-gray-50 pb-2">
                                    <span class="text-gray-500">Kelas</span>
                                    <span class="font-medium">{{ $student->grade ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>

            </div>
        </div>
    </div>
</x-landing-layout>
