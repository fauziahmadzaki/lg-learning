<div>
    <x-input-label for="name" :value="__('Nama Cabang')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
        value="{{ old('name', $branch->name ?? '') }}" autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>
<div>
    <x-input-label for="name" :value="__('Alamat Cabang')" />
    <x-text-input id="name" name="address" type="text" class="mt-1 block w-full"
        value="{{ old('address', $branch->address ?? '') }}" autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('address')" />
</div>
<div>
    <x-input-label for="name" :value="__('Kontak')" />
    <x-text-input id="name" name="phone" type="text" class="mt-1 block w-full"
        value="{{ old('phone', $branch->phone ?? '') }}" autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
</div>

<x-primary-button>Simpan</x-primary-button>