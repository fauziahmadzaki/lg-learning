<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- TUTOR SPECIFIC FIELDS --}}
        @if($user->role === 'tutor')
            <div class="border-t border-gray-100 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tutor</h3>

                {{-- Phone --}}
                <div class="mb-4">
                    <x-input-label for="phone" value="No. Telepon / WhatsApp" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->tutor?->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <x-input-label for="address" value="Alamat Domisili" />
                    <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('address', $user->tutor?->address) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                {{-- Photo Profile --}}
                <div class="mb-4" x-data="{ 
                    preview: '{{ $user->tutor?->image ? asset('storage/' . $user->tutor->image) : '' }}',
                    handleFileChange(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.preview = URL.createObjectURL(file);
                        }
                    }
                }">
                     <x-input-label for="image" value="Foto Profil" />
                     
                     <div class="flex items-center gap-4 mt-2">
                        
                        {{-- Preview Image --}}
                        <div class="shrink-0" x-show="preview">
                            <img :src="preview" alt="Foto Profil" class="h-16 w-16 object-cover rounded-full border border-gray-200">
                        </div>

                        {{-- Placeholder if no preview --}}
                        <div class="shrink-0 h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400" x-show="!preview">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>

                        <label class="block cursor-pointer">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="image" id="image" accept="image/*" @change="handleFileChange" class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100
                            "/>
                        </label>
                     </div>
                     <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>

                {{-- Jobs --}}
                <div class="mb-4">
                    <x-input-label for="jobs" value="Pekerjaan / Keahlian (Pisahkan dengan koma)" />
                    <x-text-input id="jobs" name="jobs" type="text" class="mt-1 block w-full" :value="old('jobs', implode(', ', $user->tutor?->jobs ?? []))" placeholder="Contoh: Matematika, Fisika, Guru SD" />
                    <x-input-error class="mt-2" :messages="$errors->get('jobs')" />
                </div>

                {{-- Bio --}}
                <div class="mb-4">
                    <x-input-label for="bio" value="Bio Singkat" />
                    <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('bio', $user->tutor?->bio) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                </div>

                {{-- READ ONLY INFO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <x-input-label value="Cabang (Tidak dapat diubah)" />
                        <div class="mt-1 text-gray-900 font-bold">{{ $user->tutor?->branch?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <x-input-label value="Paket yang Diampu (Hubungi Admin untuk ubah)" />
                        <div class="mt-1 flex flex-wrap gap-2">
                             @forelse($user->tutor?->packages ?? [] as $pkg)
                                <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-bold">{{ $pkg->name }}</span>
                             @empty
                                <span class="text-gray-500 italic text-sm">Belum ada paket assigned.</span>
                             @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
