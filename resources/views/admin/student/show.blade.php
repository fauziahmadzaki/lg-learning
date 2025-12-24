@php
$breadcrumbs = [
'Master Data' => null,
'Siswa' => route('admin.students.index'),
'Detail Siswa' => null,
];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Detail Siswa</x-slot>

    <div class="space-y-6">

        {{-- SECTION 1: HEADER & ACTIONS --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $student->name }}</h2>
                <p class="text-gray-500 text-sm">Bergabung sejak {{ $student->join_date->format('d M Y') }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.students.index') }}"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition">
                    &larr; Kembali
                </a>
                <a href="{{ route('admin.students.edit', $student) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-lg shadow-indigo-200 transition">
                    Edit Data
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- SECTION 2: KARTU PROFIL (KIRI) --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Card Utama --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">

                    {{-- Banner Gradient --}}
                    <div class="h-32 bg-gradient-to-br from-indigo-600 to-purple-700"></div>

                    {{-- Avatar / Inisial --}}
                    <div class="absolute top-20 left-1/2 transform -translate-x-1/2">
                        <div class="h-24 w-24 rounded-full bg-white p-1 shadow-lg">
                            <div
                                class="h-full w-full rounded-full bg-indigo-100 flex items-center justify-center text-3xl font-bold text-indigo-600">
                                {{ substr($student->name, 0, 2) }}
                            </div>
                        </div>
                    </div>

                    {{-- Info Card Body --}}
                    <div class="pt-14 pb-8 px-6 text-center">
                        {{-- Status Badge --}}
                        <div class="mb-4">
                            @if($student->status == 'active')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider rounded-full">Active
                                Student</span>
                            @elseif($student->status == 'pending')
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold uppercase tracking-wider rounded-full">Pending</span>
                            @elseif($student->status == 'finished')
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider rounded-full">Finished
                                (Selesai)</span>
                            @else
                            <span
                                class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-full">Inactive</span>
                            @endif
                        </div>

                        {{-- Kontak Info --}}
                        <div class="space-y-3 text-sm text-left mt-6 bg-gray-50 p-4 rounded-xl">
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500">Email</span>
                                <span
                                    class="font-medium text-gray-900 truncate max-w-[150px]">{{ $student->email }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500">Sekolah</span>
                                <span class="font-medium text-gray-900">{{ $student->school ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2">
                                <span class="text-gray-500">Kelas</span>
                                <span class="font-medium text-gray-900">{{ $student->grade ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between pt-1">
                                <span class="text-gray-500">Ortu</span>
                                <span class="font-medium text-gray-900">{{ $student->parent_phone }}</span>
                            </div>
                        </div>

                        {{-- Tombol WA --}}
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $student->parent_phone) }}" target="_blank"
                            class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 bg-green-50 text-green-700 font-bold rounded-xl hover:bg-green-100 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>

            </div>

            {{-- SECTION 3: INFORMASI AKADEMIK & KEUANGAN (KANAN) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- A. Info Billing & Portal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Box 1: Info Paket & Billing --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            Paket & Tagihan
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Siklus Pembayaran</p>
                                <div class="mt-1">
                                    @if($student->billing_cycle == 'monthly')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-purple-100 text-purple-800">Bulanan
                                        (Monthly)</span>
                                    @elseif($student->billing_cycle == 'weekly')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-orange-100 text-orange-800">Mingguan
                                        (Weekly)</span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">Full
                                        Payment</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold">Tagihan Berikutnya</p>
                                <p class="text-gray-900 font-medium">
                                    @php
                                        // LOGIKA BARU: Tri-State (Lunas Selesai, Belum Lunas, atau Masih Jalan)
                                        $statusDisplay = 'ONGOING'; // Default
                                        
                                        // $isPeriodOver passed from Controller
                                        if ($isPeriodOver) {
                                            $hasUnpaidBills = $student->bills->where('status', '!=', 'PAID')->count() > 0;
                                            
                                            if (!$hasUnpaidBills) {
                                                $statusDisplay = 'FINISHED_PAID'; // Lunas & Selesai
                                            } else {
                                                $statusDisplay = 'FINISHED_UNPAID'; // Selesai tapi nunggak
                                            }
                                        }

                                        // Compatibility variable for existing UI logic below
                                        $isFullyPaid = ($statusDisplay === 'FINISHED_PAID');
                                    @endphp

                                    @if($statusDisplay === 'FINISHED_PAID')
                                        <span class="text-green-600 font-bold flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            LUNAS SEMUA (Selesai)
                                        </span>
                                    @elseif($statusDisplay === 'FINISHED_UNPAID')
                                        <span class="text-red-600 font-bold flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Selesaikan Tagihan
                                        </span>
                                    @else
                                        {{ $student->next_billing_date ? $student->next_billing_date->format('d F Y') : '-' }}
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Paket Diambil</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($student->package)
                                    <span
                                        class="px-2 py-1 bg-gray-100 border border-gray-200 text-gray-700 rounded text-xs font-medium">
                                        {{ $student->package->name }}
                                        (Rp {{ number_format($student->package->price, 0, ',', '.') }})
                                    </span>
                                    @else
                                    <span class="text-gray-400 text-sm italic">Tidak ada paket</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Form Buat Tagihan (MODAL TRIGGER) --}}
                            {{-- BUTTONS HANYA MUNCUL JIKA PERIODE BELUM HABIS --}}
                            @if($student->package && !$isPeriodOver)
                                <div class="pt-4 border-t border-gray-100 mt-4" x-data="">
                                     @php
                                        // Hitung Estimasi Nominal (Untuk Display di Modal)
                                        $estAmount = $student->package->price;
                                        if ($student->billing_cycle === 'weekly') $estAmount /= 4;
                                        elseif ($student->billing_cycle === 'full') {
                                            $m = ceil($student->package->duration / 30);
                                            $estAmount *= ($m > 0 ? $m : 1);
                                        }
                                     @endphp
                                     
                                    @if($student->status === 'pending')
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center mb-3">
                                            <p class="text-xs text-yellow-800 font-bold">
                                                <svg class="w-4 h-4 inline mr-1 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                Pendaftaran pertama harus dilunasi dulu.
                                            </p>
                                        </div>
                                        <div class="flex gap-2 opacity-50 cursor-not-allowed">
                                            <button disabled class="flex-1 py-2 bg-gray-400 text-white text-xs font-bold rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                                Buat Tagihan
                                            </button>
                                            <button disabled class="flex-1 py-2 bg-gray-400 text-white text-xs font-bold rounded-lg cursor-not-allowed flex items-center justify-center gap-2">
                                                Bayar Tunai
                                            </button>
                                        </div>
                                    @else
                                        {{-- BUTTONS ACTIVE --}}
                                        <div class="flex gap-2">
                                            <button
                                                x-on:click.prevent="$dispatch('open-modal', 'create-bill-modal')"
                                                class="flex-1 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition shadow flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                Buat Tagihan
                                            </button>

                                            <button
                                                x-on:click.prevent="$dispatch('open-modal', 'pay-manual-modal')"
                                                class="flex-1 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition shadow flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                Bayar Tunai
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <p class="text-[10px] text-gray-400 mt-2 text-center">
                                        Ini akan memajukan tanggal tagihan berikutnya.
                                    </p>

                                    {{-- MODAL 1: CREATE BILL (XENDIT) --}}
                                    <x-ui.modal name="create-bill-modal" focusable>
                                        <form method="POST" action="{{ route('admin.students.bill.store', $student) }}" class="p-6">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-900">
                                                Konfirmasi Buat Tagihan
                                            </h2>

                                            <div class="mt-4 text-sm text-gray-600 space-y-3">
                                                <p>Anda akan membuat tagihan <strong>Menunggu Pembayaran (Pending)</strong>. Link Xendit akan dibuat otomatis.</p>
                                                
                                                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                                    <div class="flex justify-between">
                                                        <span>Paket:</span>
                                                        <span class="font-bold">{{ $student->package->name }}</span>
                                                    </div>
                                                    <div class="flex justify-between mt-1">
                                                        <span>Nominal:</span>
                                                        <span class="font-bold text-lg">Rp {{ number_format($estAmount, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex justify-end gap-3">
                                                <x-buttons.secondary x-on:click="$dispatch('close')">
                                                    Batal
                                                </x-buttons.secondary>

                                                <x-buttons.primary class="bg-indigo-600 hover:bg-indigo-700">
                                                    Ya, Generate Invoice
                                                </x-buttons.primary>
                                            </div>
                                        </form>
                                    </x-ui.modal>

                                    {{-- MODAL 2: PAY MANUAL (CASH / RECORD LUNAS) --}}
                                    <x-ui.modal name="pay-manual-modal" focusable>
                                        <form method="POST" action="{{ route('admin.students.pay.manual', $student) }}" class="p-6">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-900">
                                                Konfirmasi Pembayaran Tunai
                                            </h2>

                                            <div class="mt-4 text-sm text-gray-600 space-y-3">
                                                <p>Anda akan mencatat pembayaran <strong>TUNAI / CASH</strong> untuk siswa <strong>{{ $student->name }}</strong>. Status tagihan akan langsung dicatat <strong>LUNAS</strong> dalam sistem.</p>
                                                
                                                <div class="bg-green-50 p-3 rounded-lg border border-green-100">
                                                    <div class="flex justify-between">
                                                        <span>Paket:</span>
                                                        <span class="font-bold">{{ $student->package->name }}</span>
                                                    </div>
                                                    <div class="flex justify-between mt-1 pt-1 border-t border-green-200">
                                                        <span>Total Dibayar:</span>
                                                        <span class="font-bold text-lg text-green-700">Rp {{ number_format($estAmount, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex justify-end gap-3">
                                                <x-buttons.secondary x-on:click="$dispatch('close')">
                                                    Batal
                                                </x-buttons.secondary>

                                                <x-buttons.primary class="bg-green-600 hover:bg-green-700 focus:ring-green-500">
                                                    konfirmasi Pembayaran Tunai
                                                </x-buttons.primary>
                                            </div>
                                        </form>
                                    </x-ui.modal>
                                </div>
                            @elseif($isFullyPaid)
                                <div class="pt-4 border-t border-gray-100 mt-4 text-center">
                                    <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200">
                                        <p class="font-bold text-sm">Tagihan Selesai</p>
                                        <p class="text-xs mt-1">Siswa telah melunasi seluruh periode paket belajar.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Box 2: Link Portal (Alpine JS Copy) --}}
                    <div class="bg-indigo-900 p-6 rounded-2xl shadow-sm text-white relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl">
                        </div>

                        <h3 class="font-bold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                            Akses Portal Siswa
                        </h3>
                        <p class="text-indigo-200 text-xs mb-4">
                            Bagikan link ini ke orang tua untuk melihat jadwal dan membayar tagihan tanpa login.
                        </p>

                        {{-- Input Copy --}}
                        <div x-data="{ copied: false }">
                            <div
                                class="flex items-center gap-2 bg-indigo-800/50 p-1.5 rounded-lg border border-indigo-700">
                                <input type="text" readonly value="{{ url('/portal/' . $student->access_token) }}"
                                    class="bg-transparent border-none text-xs text-indigo-100 w-full focus:ring-0 px-2 truncate">

                                <button
                                    @click="navigator.clipboard.writeText('{{ url('/portal/' . $student->access_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="bg-white text-indigo-900 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-indigo-50 transition flex-shrink-0">
                                    <span x-show="!copied">Copy</span>
                                    <span x-show="copied" style="display: none;">Copied!</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- B. Tabel Tagihan & Transaksi (Tabs Style) --}}
                {{-- BAGIAN TABULASI KEUANGAN --}}
                <div x-data="{ activeTab: 'bills' }"
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-6">

                    {{-- 1. Header Tab --}}
                    <div class="flex border-b border-gray-200 bg-gray-50">
                        {{-- Tab Tagihan --}}
                        <button @click="activeTab = 'bills'"
                            class="flex-1 py-4 text-sm font-bold text-center transition focus:outline-none relative"
                            :class="activeTab === 'bills' ? 'text-indigo-600 bg-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'">

                            Tagihan / Keranjang
                            {{-- Badge Hitungan Tagihan Belum Lunas --}}
                            @php $unpaidCount = $student->bills->where('status', '!=', 'PAID')->count(); @endphp
                            @if($unpaidCount > 0)
                            <span class="ml-2 bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-xs">
                                {{ $unpaidCount }}
                            </span>
                            @endif

                            {{-- Garis Bawah Aktif --}}
                            <div x-show="activeTab === 'bills'"
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600"></div>
                        </button>

                        {{-- Tab Riwayat --}}
                        <button @click="activeTab = 'history'"
                            class="flex-1 py-4 text-sm font-bold text-center transition focus:outline-none relative"
                            :class="activeTab === 'history' ? 'text-indigo-600 bg-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'">
                            Riwayat Pembayaran
                            <div x-show="activeTab === 'history'"
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600"></div>
                        </button>

                        {{-- Tab Tabungan --}}
                        <button @click="activeTab = 'savings'"
                            class="flex-1 py-4 text-sm font-bold text-center transition focus:outline-none relative"
                            :class="activeTab === 'savings' ? 'text-indigo-600 bg-white' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'">
                            Tabungan
                             <div x-show="activeTab === 'savings'"
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600"></div>
                        </button>
                    </div>

                    {{-- 2. Content Tab: TAGIHAN (BILLS) --}}
                    <div x-show="activeTab === 'bills'" x-transition.opacity class="p-0">
                        @if($student->bills->where('status', '!=', 'PAID')->count() > 0)
                        <div class="overflow-x-auto">
                            <x-ui.table :headers="['Deskripsi Tagihan', 'Jatuh Tempo', 'Nominal', 'Status']">
    {{-- Filter hanya menampilkan yang BELUM LUNAS --}}
    @foreach($student->bills->where('status', '!=', 'PAID') as $bill)
    <x-ui.tr>
        <x-ui.td class="font-medium text-gray-900">
            {{ $bill->title }}
            <div class="text-xs text-gray-400 font-normal mt-0.5">ID: #BILL-{{ $bill->id }}</div>
        </x-ui.td>
        <x-ui.td class="text-gray-600">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $bill->due_date->format('d M Y') }}
            </div>
        </x-ui.td>
        <x-ui.td class="text-right font-bold text-gray-900">
            Rp {{ number_format($bill->amount, 0, ',', '.') }}
        </x-ui.td>
        <x-ui.td class="text-center">
            @if($bill->status == 'UNPAID')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                Belum Bayar
            </span>
            @elseif($bill->status == 'PENDING')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                Menunggu
            </span>
            @endif
            
            {{-- TOMBOL LUNASKAN (MODAL TRIGGER) --}}
            <div class="mt-2" x-data="">
                <button x-on:click.prevent="$dispatch('open-modal', 'pay-bill-{{ $bill->id }}')" 
                    class="text-xs text-indigo-600 hover:text-indigo-900 font-bold underline">
                    Lunaskan (Cash)
                </button>

                {{-- MODAL LUNASKAN PER TAGIHAN --}}
                <x-ui.modal name="pay-bill-{{ $bill->id }}" focusable>
                    <form method="POST" action="{{ route('admin.students.bills.pay_manual', [$student, $bill]) }}" class="p-6 text-left">
                        @csrf
                        
                        <h2 class="text-lg font-medium text-gray-900">
                            Konfirmasi Pelunasan Tagihan
                        </h2>

                        <div class="mt-4 text-sm text-gray-600 space-y-3">
                            <p>Anda akan mencatat pembayaran <strong>TUNAI / CASH</strong> untuk tagihan ini secara manual.</p>
                            
                            <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-100">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs text-gray-500">Judul Tagihan:</span>
                                    <span class="font-bold text-gray-800">{{ $bill->title }}</span>
                                </div>
                                <div class="flex justify-between mt-2 pt-2 border-t border-yellow-200">
                                    <span>Nominal:</span>
                                    <span class="font-bold text-lg text-indigo-700">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <x-buttons.secondary x-on:click="$dispatch('close')">
                                Batal
                            </x-buttons.secondary>

                            <x-buttons.primary class="bg-indigo-600 hover:bg-indigo-700">
                                Ya, Lunaskan Sekarang
                            </x-buttons.primary>
                        </div>
                    </form>
                </x-ui.modal>
            </div>
        </x-ui.td>
    </x-ui.tr>
    @endforeach
    {{-- Footer Total Tagihan --}}
    <x-slot:footer>
        <tfoot class="bg-gray-50 border-t border-gray-200">
            <tr>
                <td colspan="2" class="px-6 py-3 text-right font-bold text-gray-600">Total Tagihan Aktif:</td>
                <td class="px-6 py-3 text-right font-bold text-indigo-600 text-lg">
                    Rp {{ number_format($student->bills->where('status', '!=', 'PAID')->sum('amount'), 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
    </x-slot:footer>
</x-ui.table>
                        </div>

                        {{-- Info Tambahan --}}
                        <div
                            class="p-4 bg-blue-50 text-blue-800 text-xs flex items-center gap-2 border-t border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tagihan ini akan otomatis muncul di Portal Siswa untuk dibayar oleh Wali Murid.
                        </div>

                        @else
                        {{-- Empty State Tagihan --}}
                        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                            <div class="bg-green-100 p-4 rounded-full mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-gray-900 font-medium text-lg">Tidak Ada Tagihan</h3>
                            <p class="text-gray-500 text-sm mt-1 max-w-xs">Siswa ini tidak memiliki tunggakan pembayaran
                                saat ini.</p>
                        </div>
                        @endif
                    </div>

                    {{-- 3. Content Tab: RIWAYAT (HISTORY) --}}
                    <div x-show="activeTab === 'history'" x-transition.opacity class="p-0" style="display: none;">
                        @if($student->transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <x-ui.table :headers="['Invoice', 'Tanggal Bayar', 'Paket', 'Metode', 'Total', 'Status']">
    @foreach($student->transactions as $trx)
    <x-ui.tr>
        <x-ui.td class="font-medium text-indigo-600">
            {{ $trx->invoice_code }}
        </x-ui.td>
        <x-ui.td class="text-gray-600">
            {{ $trx->paid_at ? $trx->paid_at->format('d M Y H:i') : $trx->created_at->format('d M Y') }}
        </x-ui.td>
        <x-ui.td>
             <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $trx->student->package->name ?? '-' }}</span>
        </x-ui.td>
        <x-ui.td class="text-gray-600">
            <span class="uppercase text-xs font-bold">{{ $trx->payment_method ?? '-' }}</span>
            <span class="text-xs text-gray-400 block">{{ $trx->payment_channel }}</span>
        </x-ui.td>
        <x-ui.td class="text-right font-bold text-gray-900">
            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
        </x-ui.td>
        <x-ui.td class="text-center">
            @if($trx->status == 'PAID')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                LUNAS
            </span>
            @elseif($trx->status == 'PENDING')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                PENDING
            </span>
            @elseif($trx->status == 'EXPIRED')
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                EXPIRED
            </span>
            @else
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                GAGAL
            </span>
            @endif
        </x-ui.td>
    </x-ui.tr>
    @endforeach
</x-ui.table>
                        </div>
                        @else
                        {{-- Empty State Riwayat --}}
                        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-gray-900 font-medium text-lg">Belum Ada Riwayat</h3>
                            <p class="text-gray-500 text-sm mt-1">Siswa ini belum pernah melakukan transaksi pembayaran
                                via sistem.</p>
                        </div>
                        @endif
                    </div>
                
                {{-- 4. Content Tab: TABUNGAN (SAVINGS) --}}
                <div x-show="activeTab === 'savings'" x-transition.opacity class="p-6" style="display: none;">
                    
                    {{-- Balance Card --}}
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white mb-6 flex justify-between items-center shadow-lg">
                        <div>
                            <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-1">Total Tabungan</p>
                            <h3 class="text-3xl font-bold">Rp {{ number_format($student->savings_balance, 0, ',', '.') }}</h3>
                        </div>
                        <div class="flex gap-3">
                            {{-- Deposit Button --}}
                            <button x-on:click.prevent="$dispatch('open-modal', 'savings-deposit-modal')" 
                                class="bg-white text-blue-700 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-bold shadow transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Deposit
                            </button>
                            {{-- Withdraw Button --}}
                            <button x-on:click.prevent="$dispatch('open-modal', 'savings-withdraw-modal')"
                                class="bg-indigo-800 text-white hover:bg-indigo-900 px-4 py-2 rounded-lg text-sm font-bold shadow transition flex items-center gap-2 border border-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                Tarik
                            </button>
                        </div>
                    </div>

                    {{-- History Savings --}}
                    <h4 class="font-bold text-gray-800 mb-3">Riwayat Transaksi Tabungan</h4>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                        <x-ui.table :headers="['Tanggal', 'Tipe', 'Keterangan', 'Nominal']">
                            @forelse($student->transactions()->whereIn('type', ['SAVINGS_DEPOSIT', 'SAVINGS_WITHDRAWAL'])->latest()->take(10)->get() as $log)
                            <x-ui.tr>
                                <x-ui.td class="text-gray-600">{{ $log->created_at->format('d M Y H:i') }}</x-ui.td>
                                <x-ui.td>
                                    @if($log->type == 'SAVINGS_DEPOSIT')
                                        <span class="text-green-600 font-bold text-xs uppercase bg-green-100 px-2 py-1 rounded">Deposit</span>
                                    @else
                                        <span class="text-red-600 font-bold text-xs uppercase bg-red-100 px-2 py-1 rounded">Penarikan</span>
                                    @endif
                                </x-ui.td>
                                <x-ui.td class="text-gray-500 text-sm">{{ $log->description ?? '-' }}</x-ui.td>
                                <x-ui.td class="text-right font-bold {{ $log->type == 'SAVINGS_WITHDRAWAL' ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $log->type == 'SAVINGS_WITHDRAWAL' ? '-' : '+' }} Rp {{ number_format($log->total_amount, 0, ',', '.') }}
                                </x-ui.td>
                            </x-ui.tr>
                            @empty
                            <x-ui.tr>
                                <x-ui.td colspan="4" class="text-center py-6 text-gray-400">Belum ada transaksi tabungan.</x-ui.td>
                            </x-ui.tr>
                            @endforelse
                        </x-ui.table>
                    </div>

                    {{-- MODALS --}}
                    {{-- Deposit Modal --}}
                    <x-ui.modal name="savings-deposit-modal" focusable>
                        <form method="POST" action="{{ route('admin.students.savings.deposit', $student) }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Tambah Deposit Tabungan</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nominal Deposit (Rp)</label>
                                    <input type="number" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 50000" required min="1000">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                    <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Setoran tunai mingguan"></textarea>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end gap-3">
                                <x-buttons.secondary x-on:click="$dispatch('close')">Batal</x-buttons.secondary>
                                <x-buttons.primary class="bg-green-600 hover:bg-green-700">Simpan Deposit</x-buttons.primary>
                            </div>
                        </form>
                    </x-ui.modal>

                    {{-- Withdraw Modal --}}
                    <x-ui.modal name="savings-withdraw-modal" focusable>
                        <form method="POST" action="{{ route('admin.students.savings.withdraw', $student) }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Tarik Saldo Tabungan</h2>
                             <div class="bg-red-50 p-3 rounded-lg border border-red-100 mb-4">
                                <p class="text-sm text-red-700">Saldo saat ini: <strong>Rp {{ number_format($student->savings_balance, 0, ',', '.') }}</strong></p>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nominal Penarikan (Rp)</label>
                                    <input type="number" name="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: 50000" required min="1000" max="{{ $student->savings_balance }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan / Alasan</label>
                                    <textarea name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Contoh: Untuk bayar outbond"></textarea>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end gap-3">
                                <x-buttons.secondary x-on:click="$dispatch('close')">Batal</x-buttons.secondary>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Konfirmasi Penarikan
                                </button>
                            </div>
                        </form>
                    </x-ui.modal>

                </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>