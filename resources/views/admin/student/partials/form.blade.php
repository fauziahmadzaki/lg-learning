@props(['student' => null, 'packages' => []])

{{--
    SETUP ALPINE JS 
    Kita inisialisasi state untuk 'status' dan 'billing_cycle'.
    Prioritas nilai: 1. Old Input (Validasi Gagal) -> 2. Data Database (Edit) -> 3. Default
--}}
<div x-data="{ 
    status: '{{ old('status', $student?->status ?? 'pending') }}',
    billing_cycle: '{{ old('billing_cycle', $student?->billing_cycle ?? 'monthly') }}'
}" class="space-y-8">

    {{-- BAGIAN 1: DATA PRIBADI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Nama Siswa --}}
        <div class="col-span-1 md:col-span-2">
            <x-inputs.label for="name" :value="__('Nama Lengkap Siswa')" />
            <x-inputs.text id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name', $student?->name)" required autofocus placeholder="Contoh: Muhammad Rizky" />
            <x-inputs.error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Siswa --}}
        <div>
            <x-inputs.label for="email" :value="__('Email Siswa')" />
            <x-inputs.text id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email', $student?->email)" required placeholder="email@contoh.com" />
            <x-inputs.error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- No HP Orang Tua --}}
        <div>
            <x-inputs.label for="parent_phone" :value="__('No. WhatsApp Orang Tua')" />
            <x-inputs.text id="parent_phone" class="block mt-1 w-full" type="number" name="parent_phone"
                :value="old('parent_phone', $student?->parent_phone)" required placeholder="0812xxxx" />
            <x-inputs.error :messages="$errors->get('parent_phone')" class="mt-2" />
        </div>

        {{-- Asal Sekolah --}}
        <div>
            <x-inputs.label for="school" :value="__('Asal Sekolah')" />
            <x-inputs.text id="school" class="block mt-1 w-full" type="text" name="school"
                :value="old('school', $student?->school)" required placeholder="Contoh: SMAN 1 Jakarta" />
            <x-inputs.error :messages="$errors->get('school')" class="mt-2" />
        </div>

        {{-- Jenjang / Kelas (Sekolah) --}}
        <div>
            <x-inputs.label for="grade" :value="__('Kelas / Jenjang Sekolah')" />
            <x-inputs.text id="grade" class="block mt-1 w-full" type="text" name="grade"
                :value="old('grade', $student?->grade)" required placeholder="Contoh: 12 SMA" />
            <x-inputs.error :messages="$errors->get('grade')" class="mt-2" />
        </div>

        {{-- Tanggal Gabung --}}
        <div>
            <x-inputs.label for="join_date" :value="__('Tanggal Bergabung')" />
            <x-inputs.text id="join_date"
                class="block mt-1 w-full {{ $student ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}"
                type="date" name="join_date"
                :value="old('join_date', $student?->join_date ? $student->join_date->format('Y-m-d') : date('Y-m-d'))"
                required :readonly="$student ? true : false" />
            @if($student)
            <p class="text-xs text-red-500 mt-1">* Tanggal gabung tidak dapat diubah.</p>
            @endif
            <x-inputs.error :messages="$errors->get('join_date')" class="mt-2" />
        </div>

    </div>

    {{-- BAGIAN 2: PENGATURAN BILLING & PAKET (BARU) --}}
    <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-100">
        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            Pengaturan Tagihan & Paket
        </h3>

        {{-- A. Tipe Tagihan (Billing Cycle) --}}
        <div class="mb-6">
            <x-inputs.label :value="__('Siklus Pembayaran')" class="mb-2" />

            @if($student)
            {{-- MODE EDIT: Tampilkan Read-Only --}}
            <div class="p-4 bg-gray-100 border border-gray-200 rounded-lg flex items-start gap-3">
                <div class="bg-indigo-100 p-2 rounded-full text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Siklus Pembayaran Terpilih:</p>
                    <p class="text-lg font-bold text-gray-900 uppercase tracking-wide">
                        @if($student->billing_cycle === 'monthly')
                        Bulanan
                        @elseif($student->billing_cycle === 'weekly')
                        Mingguan
                        @elseif($student->billing_cycle === 'full')
                        Lunas / Full
                        @else
                        {{ $student->billing_cycle }}
                        @endif
                    </p>
                    <p class="text-xs text-red-500 mt-1">
                        * Metode pembayaran tidak dapat diubah setelah pendaftaran.
                    </p>
                </div>
            </div>
            @else
            {{-- MODE CREATE: Tampilkan Pilihan Radio --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                {{-- Opsi Monthly --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="billing_cycle" value="monthly" x-model="billing_cycle" class="sr-only">
                    <div class="text-center p-3 rounded-lg border-2 transition-all"
                        :class="billing_cycle === 'monthly' ? 'border-indigo-500 bg-white text-indigo-700 shadow-md' : 'border-indigo-200 text-gray-500 bg-indigo-50/50 hover:bg-white'">
                        <div class="font-bold text-sm">Bulanan</div>
                        <div class="text-[10px]">Bayar per Bulan</div>
                    </div>
                </label>

                {{-- Opsi Weekly --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="billing_cycle" value="weekly" x-model="billing_cycle" class="sr-only">
                    <div class="text-center p-3 rounded-lg border-2 transition-all"
                        :class="billing_cycle === 'weekly' ? 'border-orange-500 bg-white text-orange-700 shadow-md' : 'border-indigo-200 text-gray-500 bg-indigo-50/50 hover:bg-white'">
                        <div class="font-bold text-sm">Mingguan</div>
                        <div class="text-[10px]">Dicicil 4x Sebulan</div>
                    </div>
                </label>

                {{-- Opsi Full --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="billing_cycle" value="full" x-model="billing_cycle" class="sr-only">
                    <div class="text-center p-3 rounded-lg border-2 transition-all"
                        :class="billing_cycle === 'full' ? 'border-green-500 bg-white text-green-700 shadow-md' : 'border-indigo-200 text-gray-500 bg-indigo-50/50 hover:bg-white'">
                        <div class="font-bold text-sm">Lunas / Full</div>
                        <div class="text-[10px]">Bayar Langsung</div>
                    </div>
                </label>
            </div>
            <x-inputs.error :messages="$errors->get('billing_cycle')" class="mt-2" />
            @endif
        </div>
        {{-- B. Pilih Paket --}}
        <div>
            <x-inputs.label for="package_id" :value="__('Pilih Paket Belajar')" />
            <x-inputs.select id="package_id" name="package_id" :disabled="$student"
                class="mt-1 block w-full {{ $student ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}">
                <option value="" disabled selected>-- Pilih Paket Bimbel --</option>
                @foreach($packages as $package)
                <option value="{{ $package->id }}" @if(old('package_id', $student?->package_id) == $package->id) selected @endif>
                    {{ $package->name }} ({{ $package->branch->name ?? 'N/A' }})
                    
                    <span x-show="billing_cycle === 'monthly'">(Rp
                        {{ number_format($package->price, 0, ',', '.') }}/bln)</span>
                    <span x-show="billing_cycle === 'weekly'">(~Rp
                        {{ number_format($package->price / 4, 0, ',', '.') }}/mgg)</span>
                </option>
                @endforeach
            </x-inputs.select>

            @if($student)
            <input type="hidden" name="package_id" value="{{ $student->package_id }}">
            <p class="text-xs text-red-500 mt-1">* Paket tidak dapat diubah setelah pendaftaran.</p>
            @endif
            <p class="text-xs text-gray-500 mt-1" x-show="billing_cycle === 'weekly'">
                *Harga mingguan adalah estimasi (Harga Paket / 4).
            </p>
            <x-inputs.error :messages="$errors->get('package_id')" class="mt-2" />
        </div>
    </div>

    {{-- BAGIAN 3: STATUS SISWA --}}
    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
        <x-inputs.label :value="__('Status Keaktifan Siswa')" class="mb-3 text-lg" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @if(!($student && $student->status === 'active'))
            {{-- Opsi 1: PENDING --}}
            <label class="cursor-pointer relative group">
                <input type="radio" name="status" value="pending" x-model="status" class="sr-only">
                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'pending' 
                        ? 'border-yellow-400 bg-yellow-50 ring-1 ring-yellow-400' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'pending' ? 'text-yellow-800' : 'text-gray-700'">
                            Pending (Baru Daftar)
                        </span>
                        <div x-show="status === 'pending'" class="text-yellow-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Siswa baru mendaftar, belum ada pembayaran masuk.</p>
                </div>
            </label>
            @endif

            {{-- Opsi 2: ACTIVE --}}
            <label class="cursor-pointer relative group">
                <input type="radio" name="status" value="active" x-model="status" class="sr-only">
                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'active' 
                        ? 'border-green-500 bg-green-50 ring-1 ring-green-500' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'active' ? 'text-green-800' : 'text-gray-700'">
                            Active (Siswa Aktif)
                        </span>
                        <div x-show="status === 'active'" class="text-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Siswa aktif mengikuti kegiatan belajar.</p>
                </div>
            </label>

            {{-- Opsi 3: INACTIVE (Hanya muncul saat Edit atau jika statusnya memang inactive) --}}
            @if($student)
            <label class="cursor-pointer relative md:col-span-2 group">
                <input type="radio" name="status" value="inactive" x-model="status" class="sr-only">
                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'inactive' 
                        ? 'border-gray-500 bg-gray-100 ring-1 ring-gray-500' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'inactive' ? 'text-gray-900' : 'text-gray-700'">
                            Inactive (Cuti / Berhenti)
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">Tidak menerima tagihan dan tidak mengikuti kelas.</p>
                </div>
            </label>
            @endif

        </div>
        <x-inputs.error :messages="$errors->get('status')" class="mt-2" />
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
        <a href="{{ route('admin.students.index') }}"
            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition">
            Batal
        </a>
        <x-buttons.primary class="px-6">
            {{ $submit_text ?? 'Simpan Data' }}
        </x-buttons.primary>
    </div>

</div>