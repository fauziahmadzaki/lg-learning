@php
    $breadcrumbs = [
        'Profil' => null,
    ];
@endphp

<x-app-layout pageTitle="Profil Saya" :breadcrumbs="$breadcrumbs">
    
    <div class="space-y-10">
        {{-- Profile Information --}}
        <section>
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Informasi Profil') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
                </p>
            </header>
            @include('profile.partials.update-profile-information-form')
        </section>

        <x-ui.section-border />

        {{-- Update Password --}}
        <section>
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Perbarui Kata Sandi') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
                </p>
            </header>
            @include('profile.partials.update-password-form')
        </section>

        <x-ui.section-border />

        {{-- Delete User --}}
        <section>
            <header class="mb-4">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Hapus Akun') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.') }}
                </p>
            </header>
            @include('profile.partials.delete-user-form')
        </section>
    </div>
</x-app-layout>
