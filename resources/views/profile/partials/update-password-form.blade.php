<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Perbarui Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-inputs.label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-inputs.text id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-inputs.error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-inputs.label for="update_password_password" :value="__('Kata Sandi Baru')" />
            <x-inputs.text id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-inputs.error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-inputs.label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-inputs.text id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-inputs.error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-buttons.primary>{{ __('Simpan') }}</x-buttons.primary>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
