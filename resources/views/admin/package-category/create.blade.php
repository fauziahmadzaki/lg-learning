<x-app-layout :breadcrumbs="['Kategori Paket' => route('admin.package-categories.index'), 'Tambah Baru' => null]">
    <x-slot name="pageTitle">Tambah Kategori Paket</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="p-6 md:p-8">
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Tambah Kategori Baru</h2>
                    <p class="text-sm text-gray-500 mt-1">Buat kategori jenjang baru (misal: SD, SMP, SMA, UTBK).</p>
                </div>

                <form action="{{ route('admin.package-categories.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        {{-- Nama Kategori --}}
                        <div>
                            <x-inputs.label for="name" :value="__('Nama Kategori')" />
                            <x-inputs.text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: SD, SMP, SMA" />
                            <x-inputs.error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Slug (Opsional) --}}
                        <div>
                            <x-inputs.label for="slug" :value="__('Slug (Opsional)')" />
                            <x-inputs.text id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" placeholder="contoh: sd, smp-kelas-7" />
                            <p class="text-xs text-gray-400 mt-1">Kosongkan untuk generate otomatis dari nama.</p>
                            <x-inputs.error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <x-inputs.label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-inputs.error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.package-categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition">
                            Batal
                        </a>
                        <x-buttons.primary class="px-6">Simpan Kategori</x-buttons.primary>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
