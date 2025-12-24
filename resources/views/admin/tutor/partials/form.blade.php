@props(['tutor' => null, 'branches', 'packages' => []])

{{--
    LOGIKA ALPINE JS (GABUNGAN)
    Kita simpan state untuk:
    1. jobs: Mengambil data pekerjaan lama (kalau edit) atau array kosong (kalau baru).
    2. imagePreview: Mengambil URL foto lama (kalau ada).
--}}
<div x-data="{ 
    jobs: {{ old('jobs') ? json_encode(old('jobs')) : ($tutor && $tutor->jobs ? json_encode($tutor->jobs) : json_encode([''])) }},
    
    // State untuk filter paket berdasarkan cabang
    branchId: '{{ old('branch_id', $tutor?->branch_id) }}',
    allPackages: @js($packages), // Pass semua data paket ke Alpine
    
    // Computed: Paket yang tersedia sesuai cabang dipilih
    get availablePackages() {
        if (!this.branchId) return [];
        return this.allPackages.filter(pkg => pkg.branch_id == this.branchId);
    },

    imagePreview: '{{ $tutor && $tutor->image ? asset('storage/'.$tutor->image) : '' }}',

    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            this.imagePreview = URL.createObjectURL(file);
        }
    },

    addJob() {
        this.jobs.push('');
    },

    removeJob(index) {
        if(this.jobs.length > 1) {
            this.jobs.splice(index, 1);
        }
    }
}">

    {{-- BAGIAN 1: AKUN LOGIN (USER) --}}
    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Akun</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-inputs.label for="name" :value="__('Nama Lengkap')" />
            <x-inputs.text id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $tutor?->user->name)" required />
            <x-inputs.error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-inputs.label for="email" :value="__('Email')" />
            <x-inputs.text id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $tutor?->user->email)" required />
            <x-inputs.error class="mt-2" :messages="$errors->get('email')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <x-inputs.label for="password" :value="__('Password')" />
            <x-inputs.text id="password" name="password" type="password" class="mt-1 block w-full" />
            <p class="text-xs text-gray-500 mt-1">
                {{ $tutor ? 'Kosongkan jika tidak ingin mengganti password.' : 'Wajib diisi untuk akun baru.' }}
            </p>
            <x-inputs.error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-inputs.label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-inputs.text id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" />
        </div>
    </div>

    {{-- BAGIAN 2: DATA TUTOR --}}
    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2 mt-8">Profil Tutor</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <x-inputs.label for="phone" :value="__('No. Telepon')" />
            <x-inputs.text id="phone" name="phone" type="text" class="mt-1 block w-full"
                :value="old('phone', $tutor?->phone)" />
            <x-inputs.error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-inputs.label for="address" :value="__('Alamat Domisili')" />
            <x-inputs.text id="address" name="address" type="text" class="mt-1 block w-full"
                :value="old('address', $tutor?->address)" />
            <x-inputs.error class="mt-2" :messages="$errors->get('address')" />
        </div>
    </div>

    <div class="mb-4">
        <x-inputs.label for="branch_id" :value="__('Penempatan Cabang')" />

        <x-inputs.select id="branch_id" name="branch_id" x-model="branchId" class="mt-1 block w-full">
            <option value="" disabled selected>-- Pilih Cabang --</option>

            @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{-- Logika Selected: --}} {{-- 1. Cek old input (kalau validasi gagal)
                --}} {{-- 2. Cek data database (kalau lagi edit) --}} @selected(old('branch_id', $tutor?->branch_id) ==
                $branch->id)
                >
                {{ $branch->name }}
            </option>
            @endforeach
        </x-inputs.select>

        <x-inputs.error class="mt-2" :messages="$errors->get('branch_id')" />
    </div>

    <div class="mb-4">
        <x-inputs.label for="bio" :value="__('Biografi Singkat')" />
        <textarea id="bio" name="bio" rows="3"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('bio', $tutor?->bio) }}</textarea>
        <x-inputs.error class="mt-2" :messages="$errors->get('bio')" />
    </div>

    {{-- BAGIAN 3: PAKET YANG DIAMPU (BARU) --}}
    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2 mt-8">Paket / Kelas yang Diampu</h3>
    
    <div class="mb-6">
        <x-inputs.label for="packages" :value="__('Pilih Paket Belajar (Bisa Lebih dari 1)')" />
        <div class="mt-1">
            <x-inputs.select name="packages[]" id="packages" multiple class="block w-full h-40">
                
                {{-- Opsi Default jika belum pilih cabang --}}
                <option value="" disabled x-show="!branchId">-- Pilih Cabang Terlebih Dahulu --</option>
                
                {{-- Loop Paket via JS --}}
                <template x-for="pkg in availablePackages" :key="pkg.id">
                    <option :value="pkg.id" 
                        {{-- Logic selected untuk JS agak tricky, kita gunakan server-side helper array di x-init atau biarkan user pilih ulang --}}
                        {{-- Tapi karena ini ganti cabang = reset paket biasanya, jadi kita biarkan kosong kecuali ada logic complex --}}
                        :selected="@js(old('packages') ?? ($tutor ? $tutor->packages->pluck('id')->toArray() : [])).includes(pkg.id)"
                        <span x-text="pkg.name"></span> (<span x-text="pkg.branch?.name || '-'"></span>)
                    </option>
                </template>
            </x-inputs.select>
            <p class="mt-1 text-xs text-gray-500">
                💡 Tips: Tahan tombol <strong>CTRL</strong> (Windows) atau <strong>CMD</strong> (Mac) untuk memilih
                beberapa paket sekaligus.
            </p>
            <x-inputs.error class="mt-2" :messages="$errors->get('packages')" />
            @if($errors->has('packages.*'))
                <ul class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach($errors->get('packages.*') as $errorsArray)
                        @foreach($errorsArray as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- FITUR DYNAMIC INPUT (PEKERJAAN/JOBS) --}}
    <div class="mb-6">
        <x-inputs.label :value="__('Riwayat Pekerjaan / Keahlian')" class="mb-2" />

        {{-- Loop input berdasarkan state Alpine 'jobs' --}}
        <template x-for="(job, index) in jobs" :key="index">
            <div class="flex flex-col mb-2">
                <div class="flex gap-2">
                    <x-inputs.text name="jobs[]" type="text" class="block w-full"
                        placeholder="Contoh: Guru Matematika SMAN 1" x-model="jobs[index]" />

                    <button type="button" @click="removeJob(index)"
                        class="text-red-500 hover:text-red-700 px-2 border border-red-200 rounded hover:bg-red-50"
                        title="Hapus baris">
                        &times;
                    </button>
                </div>
                {{-- Show error for specific index if possible (Alpine logic vs Blade logic is tricky here) --}}
                {{-- Since we can't easily map JS index to Blade error bag dynamically without complex JS, we display general errors below --}}
            </div>
        </template>

        <button type="button" @click="addJob()" class="text-sm text-blue-600 hover:underline mt-1">
            + Tambah Pekerjaan Lain
        </button>
        
        <x-inputs.error class="mt-2" :messages="$errors->get('jobs')" />
        @if($errors->has('jobs.*'))
            <ul class="mt-2 text-sm text-red-600 space-y-1">
                @foreach($errors->get('jobs.*') as $errorsArray)
                    @foreach($errorsArray as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endforeach
            </ul>
        @endif
    </div>

    {{-- FITUR PREVIEW IMAGE --}}
    <div class="mb-6">
        <x-inputs.label for="image" :value="__('Foto Profil')" />

        <div class="mt-2 flex items-center gap-x-3">
            <div
                class="h-20 w-20 rounded-full overflow-hidden border border-gray-300 bg-gray-100 flex items-center justify-center">
                <template x-if="imagePreview">
                    <img :src="imagePreview" class="h-full w-full object-cover">
                </template>
                <template x-if="!imagePreview">
                    <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </template>
            </div>

            <div>
                <input type="file" id="image" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    @change="previewImage" />
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, max 2MB.</p>
            </div>
        </div>
        <x-inputs.error class="mt-2" :messages="$errors->get('image')" />
    </div>

    <div class="flex items-center justify-end gap-4 border-t pt-4">
        <a href="{{ $cancel_route ?? route('admin.tutors.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
        <x-buttons.primary>
            {{ $submit_text ?? 'Simpan Data' }}
        </x-buttons.primary>
    </div>
</div>