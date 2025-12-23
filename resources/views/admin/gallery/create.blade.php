<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Konten Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-8">
                
                <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data" 
                    x-data="{ 
                        isCarousel: false,
                        imagePreview: null,
                        previewImage(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.imagePreview = URL.createObjectURL(file);
                            }
                        }
                    }" class="space-y-8">
                    @csrf

                    {{-- Section 1: Informasi Konten --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Judul --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-inputs.label for="title" :value="__('Judul / Nama (Testimoni)')" />
                            <x-inputs.text id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required placeholder="Contoh: Kegiatan Belajar Mengajar..."/>
                            <x-inputs.error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Tipe & Toggle Carousel --}}
                        <div>
                            <x-inputs.label for="type" :value="__('Tipe Konten')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Testimoni">Testimoni</option>
                                <option value="Galeri">Galeri</option>
                            </select>
                            <x-inputs.error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        {{-- Toggle Carousel --}}
                        <div class="flex flex-col justify-start">
                             <span class="block font-medium text-sm text-gray-700 mb-1">Opsi Carousel</span>
                             <div class="flex items-center gap-3 mt-2">
                                <label for="is_carousel_toggle" class="flex items-center cursor-pointer relative">
                                    <input type="checkbox" id="is_carousel_toggle" class="sr-only" x-model="isCarousel">
                                    {{-- Hidden Input for Form Submission --}}
                                    <input type="hidden" name="is_carousel" :value="isCarousel ? 1 : 0">
                                    
                                    {{-- Toggle Background --}}
                                    <div class="w-11 h-6 bg-gray-200 rounded-full border border-gray-200 toggle-bg transition-colors duration-200 ease-in-out"
                                        :class="isCarousel ? 'bg-indigo-600 border-indigo-600' : 'bg-gray-200'"></div>
                                    
                                    {{-- Toggle Dot --}}
                                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition transform duration-200 ease-in-out"
                                        :class="isCarousel ? 'translate-x-full border-white' : ''"></div>
                                </label>
                                <span class="text-sm text-gray-600" x-text="isCarousel ? 'Ditampilkan di Slide Depan' : 'Tidak Ditampilkan'"></span>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-inputs.label for="description" :value="__('Deskripsi / Isi Testimoni')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Tulis deskripsi singkat...">{{ old('description') }}</textarea>
                            <x-inputs.error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                    </div>

                    {{-- Section 2: Upload Gambar --}}
                    <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Gambar / Foto
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            <div>
                                <x-inputs.label for="image" :value="__('Upload File')" />
                                <input type="file" id="image" name="image" @change="previewImage"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer" 
                                    accept="image/*">
                                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Max: 2MB.</p>
                                <x-inputs.error class="mt-2" :messages="$errors->get('image')" />
                            </div>

                            {{-- Preview Area --}}
                            <div class="border-2 border-dashed border-indigo-200 rounded-lg p-4 flex flex-col items-center justify-center min-h-[200px] bg-white"
                                :class="!imagePreview ? 'border-dashed' : 'border-solid border-indigo-300'">
                                
                                <template x-if="!imagePreview">
                                    <div class="text-center text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm">Preview gambar akan muncul di sini</p>
                                    </div>
                                </template>

                                <template x-if="imagePreview">
                                    <div class="relative w-full h-full group">
                                        <img :src="imagePreview" class="w-full h-48 object-cover rounded-md shadow-sm">
                                        <button type="button" @click="imagePreview = null; document.getElementById('image').value = ''" 
                                            class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 shadow-md hover:bg-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.contents.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition">Batal</a>
                        <x-buttons.primary class="px-6">Simpan Konten</x-buttons.primary>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
