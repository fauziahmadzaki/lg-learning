@props(['package' => null, 'branch', 'categories'])

<div x-data="{
        benefits: @js(old('benefits') ?? ($package?->benefits ?? [''])),

        imagePreview: @js($package && $package->image ? asset('storage/'.$package->image) : ''),

        // category state (old input > database > default)
        category: @js(old('category', $package?->category ?? 'ROMBEL')),

        addBenefit() {
            this.benefits.push('');
        },

        removeBenefit(index) {
            if (this.benefits.length > 1) {
                this.benefits.splice(index, 1);
            }
        },

        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        }
    }" class="space-y-8">


    {{-- BAGIAN 1: INFORMASI DASAR --}}
    <div class="border-b border-gray-200 pb-4">

        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar Paket</h3>

        <div class="grid grid-cols-1 gap-6 mb-6">
            {{-- Input Nama Paket --}}
            <div>
                <x-input-label for="name" :value="__('Nama Paket')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name', $package?->name)" placeholder="Contoh: Super Intensif UTBK" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        {{-- BAGIAN KATEGORI (FIXED STYLE) --}}
        <div class="mt-6">
            <x-input-label :value="__('Kategori Kelas')" class="mb-2" />
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- OPSI PRIVATE --}}
                <label class="cursor-pointer relative group">
                    <input type="radio" name="category" value="PRIVATE" x-model="category" class="sr-only">

                    <div class="rounded-lg p-4 flex items-center gap-3 border transition duration-200" :class="category === 'PRIVATE' 
                            ? 'border-purple-600 bg-purple-50 text-purple-700 ring-1 ring-purple-600' 
                            : 'border-gray-200 hover:bg-gray-50 text-gray-600'">

                        <div class="p-2 rounded-full"
                            :class="category === 'PRIVATE' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold">Private Class</span>
                            <span class="block text-xs opacity-80">1 Tutor untuk 1 Siswa</span>
                        </div>

                        {{-- Icon Ceklis --}}
                        <div x-show="category === 'PRIVATE'" class="ml-auto text-purple-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </label>

                {{-- OPSI ROMBEL --}}
                <label class="cursor-pointer relative group">
                    <input type="radio" name="category" value="ROMBEL" x-model="category" class="sr-only">

                    <div class="rounded-lg p-4 flex items-center gap-3 border transition duration-200" :class="category === 'ROMBEL' 
                            ? 'border-blue-600 bg-blue-50 text-blue-700 ring-1 ring-blue-600' 
                            : 'border-gray-200 hover:bg-gray-50 text-gray-600'">

                        <div class="p-2 rounded-full"
                            :class="category === 'ROMBEL' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold">Rombel Class</span>
                            <span class="block text-xs opacity-80">Belajar Berkelompok</span>
                        </div>

                        {{-- Icon Ceklis --}}
                        <div x-show="category === 'ROMBEL'" class="ml-auto text-blue-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('category')" />
        </div>

    </div>

    {{-- BAGIAN 2: DETAIL HARGA & DURASI --}}
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail & Harga</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <x-input-label for="package_category_id" :value="__('Jenjang Pendidikan')" />
                <select id="package_category_id" name="package_category_id"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="" disabled selected>-- Pilih Jenjang --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('package_category_id', $package?->package_category_id) == $cat->id)>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('package_category_id')" />
            </div>

            <div>
                <x-input-label for="price" :value="__('Harga Total (Rp)')" />
                <div class="relative mt-1 rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="price" id="price"
                        class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="0" value="{{ old('price', $package?->price) }}" required>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('price')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="duration" :value="__('Durasi Paket (Bulan)')" />
                <div class="flex gap-2 items-center">
                    <x-text-input id="duration" name="duration" type="number" class="mt-1 block w-full"
                        :value="old('duration', $package?->duration ? $package->duration / 30 : '')" placeholder="6" />
                    <span class="text-gray-500">Bulan</span>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('duration')" />
            </div>

            <div>
                <x-input-label for="session_count" :value="__('Jumlah Pertemuan')" />
                <div class="flex gap-2 items-center">
                    <x-text-input id="session_count" name="session_count" type="number" class="mt-1 block w-full"
                        :value="old('session_count', $package?->session_count)" placeholder="8" />
                    <span class="text-gray-500">Sesi</span>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('session_count')" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Deskripsi Paket')" />
            <textarea id="description" name="description" rows="3"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $package?->description) }}</textarea>
        </div>
    </div>

    {{-- BAGIAN 3: BENEFIT & PENGAJAR --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div>
            <div class="flex justify-between items-center mb-2">
                <x-input-label :value="__('Poin Keuntungan (Benefit)')" />
                <button type="button" @click="addBenefit()" class="text-sm text-blue-600 hover:underline font-medium">+
                    Tambah Poin</button>
            </div>

            <div class="space-y-2">
                <template x-for="(benefit, index) in benefits" :key="index">
                    <div class="flex gap-2">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <input type="text" name="benefits[]" x-model="benefits[index]"
                                class="block w-full rounded-md border-gray-300 pl-9 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Contoh: Modul Eksklusif">
                        </div>
                        <button type="button" @click="removeBenefit(index)"
                            class="text-gray-400 hover:text-red-500 px-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>
                {{-- Tampilkan Error Validasi Backend --}}
                <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
                <x-input-error class="mt-1" :messages="$errors->get('benefits.*')" />
            </div>
        </div>

    </div>

    {{-- BAGIAN 4: GAMBAR COVER --}}
    <div class="border-t border-gray-200 pt-6">
        <x-input-label for="image" :value="__('Gambar Cover Paket')" />

        <div class="mt-2 flex items-center gap-x-5">
            <div
                class="w-40 h-24 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center bg-gray-50">
                <template x-if="imagePreview">
                    <img :src="imagePreview" class="w-full h-full object-cover">
                </template>
                <template x-if="!imagePreview">
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                            aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-xs text-gray-500">No Image</span>
                    </div>
                </template>
            </div>

            <div class="flex-1">
                <input type="file" id="image" name="image" accept="image/*" @change="previewImage"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
        <a href="{{ route('branch.packages.index', $branch) }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
            {{ __('Batal') }}
        </a>
        <x-primary-button class="px-6">
            {{ $submit_text ?? 'Simpan Paket' }}
        </x-primary-button>
    </div>

</div>
