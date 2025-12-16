@props(['student' => null, 'packages' => []])

{{--
    SETUP ALPINE JS 
    Kita inisialisasi state 'status' di sini.
    Prioritas nilai: 1. Old Input (Validasi Gagal) -> 2. Data Database (Edit) -> 3. Default 'pending'
--}}
<div x-data="{ 
    status: '{{ old('status', $student?->status ?? 'pending') }}' 
}" class="space-y-8">

    {{-- BAGIAN 1: DATA PRIBADI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Nama Siswa --}}
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="name" :value="__('Nama Lengkap Siswa')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name', $student?->name)" required autofocus placeholder="Contoh: Muhammad Rizky" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email Siswa --}}
        <div>
            <x-input-label for="email" :value="__('Email Siswa')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email', $student?->email)" required placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- No HP Orang Tua --}}
        <div>
            <x-input-label for="parent_phone" :value="__('No. WhatsApp Orang Tua')" />
            <x-text-input id="parent_phone" class="block mt-1 w-full" type="number" name="parent_phone"
                :value="old('parent_phone', $student?->parent_phone)" required placeholder="0812xxxx" />
            <x-input-error :messages="$errors->get('parent_phone')" class="mt-2" />
        </div>

        {{-- Asal Sekolah --}}
        <div>
            <x-input-label for="school" :value="__('Asal Sekolah')" />
            <x-text-input id="school" class="block mt-1 w-full" type="text" name="school"
                :value="old('school', $student?->school)" required placeholder="Contoh: SMAN 1 Jakarta" />
            <x-input-error :messages="$errors->get('school')" class="mt-2" />
        </div>

        {{-- Jenjang / Kelas (Sekolah) --}}
        <div>
            <x-input-label for="grade" :value="__('Jenjang Sekolah')" />
            <select id="grade" name="grade"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="" disabled selected>-- Pilih Jenjang --</option>
                @foreach(['SD', 'SMP', 'SMA', 'ALUMNI'] as $gradeOption)
                <option value="{{ $gradeOption }}" @selected(old('grade', $student?->grade) == $gradeOption)>
                    {{ $gradeOption == 'ALUMNI' ? 'Alumni / Gap Year' : $gradeOption }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>

        {{-- PILIH PAKET BELAJAR --}}
        <div>
            <x-input-label for="package_id" :value="__('Pilih Paket Belajar (Kelas)')" />

            <select id="package_id" name="package_id"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="" disabled selected>-- Pilih Paket Bimbel --</option>

                @foreach($packages as $package)
                <option value="{{ $package->id }}" {{-- Logika Selected: Cek old input ATAU Cek relasi packages siswa
                    --}} @selected(old('package_id')==$package->id || ($student &&
                    $student->packages->contains($package->id)))
                    >
                    {{ $package->name }} (Rp {{ number_format($package->price, 0, ',', '.') }})
                </option>
                @endforeach
            </select>

            <p class="text-xs text-gray-500 mt-1">Siswa akan didaftarkan ke kelas ini.</p>
            <x-input-error :messages="$errors->get('package_id')" class="mt-2" />
        </div>

        {{-- Tanggal Gabung --}}
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="join_date" :value="__('Tanggal Bergabung')" />
            <x-text-input id="join_date" class="block mt-1 w-full" type="date" name="join_date"
                :value="old('join_date', $student?->join_date ? $student->join_date->format('Y-m-d') : date('Y-m-d'))"
                required />
            <x-input-error :messages="$errors->get('join_date')" class="mt-2" />
        </div>

    </div>

    {{-- BAGIAN 2: STATUS PENDAFTARAN (ALPINE JS VERSION) --}}
    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
        <x-input-label :value="__('Status Pembayaran & Pendaftaran')" class="mb-3 text-lg" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Opsi 1: PENDING --}}
            <label class="cursor-pointer relative group">
                <input type="radio" name="status" value="pending" x-model="status" class="sr-only">

                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'pending' 
                        ? 'border-yellow-400 bg-yellow-50 ring-1 ring-yellow-400' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">

                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'pending' ? 'text-yellow-800' : 'text-gray-700'">
                            Pending (Belum Bayar)
                        </span>

                        {{-- Icon Check --}}
                        <div x-show="status === 'pending'" class="text-yellow-500">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">
                        Siswa mendaftar tapi <strong>belum melakukan pembayaran</strong>. Sistem akan menunggu
                        transaksi.
                    </p>
                </div>
            </label>

            {{-- Opsi 2: ACTIVE --}}
            <label class="cursor-pointer relative group">
                <input type="radio" name="status" value="active" x-model="status" class="sr-only">

                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'active' 
                        ? 'border-green-500 bg-green-50 ring-1 ring-green-500' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">

                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'active' ? 'text-green-800' : 'text-gray-700'">
                            Active (Lunas / Siswa Lama)
                        </span>

                        {{-- Icon Check --}}
                        <div x-show="status === 'active'" class="text-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">
                        Pilih ini untuk <strong>Siswa Lama</strong> atau pembayaran <strong>Tunai/Offline</strong> di
                        tempat.
                    </p>
                </div>
            </label>

            {{-- Opsi 3: INACTIVE (Hanya saat Edit) --}}
            @if($student)
            <label class="cursor-pointer relative md:col-span-2 group">
                <input type="radio" name="status" value="inactive" x-model="status" class="sr-only">

                <div class="h-full p-4 rounded-lg border-2 transition duration-200" :class="status === 'inactive' 
                        ? 'border-gray-500 bg-gray-100 ring-1 ring-gray-500' 
                        : 'border-gray-200 bg-white hover:bg-gray-50'">

                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold" :class="status === 'inactive' ? 'text-gray-900' : 'text-gray-700'">
                            Inactive (Non-Aktif/Cuti)
                        </span>

                        {{-- Icon Check --}}
                        <div x-show="status === 'inactive'" class="text-gray-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Siswa berhenti atau cuti sementara.</p>
                </div>
            </label>
            @endif

        </div>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
        <a href="{{ route('students.index') }}"
            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition">
            Batal
        </a>
        <x-primary-button class="px-6">
            {{ $submit_text ?? 'Simpan Data' }}
        </x-primary-button>
    </div>

</div>