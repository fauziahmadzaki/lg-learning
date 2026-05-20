@props(['branch' => null])

<div class="space-y-8">

    {{-- BAGIAN 1: INFORMASI UMUM --}}
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Umum Cabang</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Nama Cabang --}}
            <div>
                <x-inputs.label for="name" :value="__('Nama Cabang')" />
                <x-inputs.text id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name', $branch->name ?? '')" placeholder="Contoh: Cabang Jakarta Selatan" required autofocus />
                <x-inputs.error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- Kontak --}}
            <div>
                <x-inputs.label for="phone" :value="__('Nomor Telepon / Kontak')" />
                <x-inputs.text id="phone" name="phone" type="text" class="mt-1 block w-full"
                    :value="old('phone', $branch->phone ?? '')" placeholder="Contoh: 0812-3456-7890" />
                <x-inputs.error class="mt-2" :messages="$errors->get('phone')" />
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika belum tersedia.</p>
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <x-inputs.label for="address" :value="__('Alamat Lengkap')" />
            <textarea id="address" name="address" rows="3"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="Masukkan alamat lengkap cabang...">{{ old('address', $branch->address ?? '') }}</textarea>
            <x-inputs.error class="mt-2" :messages="$errors->get('address')" />
        </div>

    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex items-center justify-end gap-4 pt-4">
        <a href="{{ route('admin.branches.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
            {{ __('Batal') }}
        </a>
        <x-buttons.primary class="px-6">
            {{ $submit_text ?? 'Simpan Data Cabang' }}
        </x-buttons.primary>
    </div>

</div>