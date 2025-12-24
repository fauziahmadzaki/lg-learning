<x-landing-layout>

    <div class="h-20 bg-white"></div>

    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left: Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pendaftaran</h2>
                        
                        <form action="{{ route('landing.packages.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            <div class="space-y-6">
                                {{-- Personal Info --}}
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Data Diri Siswa</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-inputs.label for="name" value="Nama Lengkap Siswa" />
                                            <x-inputs.text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                            <p class="text-[10px] text-gray-500 mt-1">Gunakan nama lengkap sesuai rapor/sekolah.</p>
                                            <x-inputs.error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-inputs.label for="school" value="Asal Sekolah" />
                                            <x-inputs.text id="school" class="block mt-1 w-full" type="text" name="school" :value="old('school')" />
                                            <x-inputs.error :messages="$errors->get('school')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-inputs.label for="grade" value="Kelas / Tingkat" />
                                            <x-inputs.text id="grade" class="block mt-1 w-full" type="text" name="grade" :value="old('grade')" placeholder="Contoh: 4 SD" />
                                            <x-inputs.error :messages="$errors->get('grade')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-inputs.label for="email" value="Email Orang Tua / Siswa" />
                                            <x-inputs.text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="user@example.com" />
                                            <p class="text-[10px] text-gray-500 mt-1">Email cadangan jika nomor WhatsApp tidak bisa dihubungi.</p>
                                            <x-inputs.error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Contact Info --}}
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Kontak & Alamat</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <x-inputs.label for="parent_phone" value="Nomor WhatsApp Orang Tua / Siswa" />
                                            <x-inputs.text id="parent_phone" class="block mt-1 w-full" type="text" name="parent_phone" :value="old('parent_phone')" placeholder="08xxxxxxxxxx" required />
                                            <p class="text-[10px] text-gray-500 mt-1">Nomor ini akan menerima notifikasi tagihan otomatis via WhatsApp.</p>
                                            <x-inputs.error :messages="$errors->get('parent_phone')" class="mt-2" />
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-inputs.label for="address" value="Alamat Domisili" />
                                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 h-24">{{ old('address') }}</textarea>
                                            <x-inputs.error :messages="$errors->get('address')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Payment Options --}}
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-100 pb-2">Pilihan Pembayaran</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" x-data="{ selected: 'full' }">
                                        @php
                                            $duration = $package->duration;
                                            $price = $package->price;
                                            $isDailyRate = $duration < 30;
                                        @endphp

                                        {{-- Daily Option (Only for <= 7 days) --}}
                                        @if($duration <= 7)
                                        <label class="cursor-pointer border-2 rounded-xl p-4 transition-all hover:border-orange-300 relative"
                                            :class="{ 'border-orange-500 bg-orange-50': selected === 'daily', 'border-gray-200': selected !== 'daily' }">
                                            <input type="radio" name="billing_cycle" value="daily" class="sr-only" x-model="selected">
                                            <div class="font-bold text-gray-900">Harian</div>
                                            <div class="text-sm text-gray-500">Bayar per hari</div>
                                            <div class="mt-2 font-bold text-orange-600">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </div>
                                        </label>
                                        @endif

                                        {{-- Weekly Option (Only for >= 7 days) --}}
                                        @if($duration >= 7)
                                        <label class="cursor-pointer border-2 rounded-xl p-4 transition-all hover:border-orange-300 relative"
                                            :class="{ 'border-orange-500 bg-orange-50': selected === 'weekly', 'border-gray-200': selected !== 'weekly' }">
                                            <input type="radio" name="billing_cycle" value="weekly" class="sr-only" x-model="selected">
                                            <div class="font-bold text-gray-900">Mingguan</div>
                                            <div class="text-sm text-gray-500">Bayar per minggu</div>
                                            <div class="mt-2 font-bold text-orange-600">
                                                @php
                                                    $weeklyPrice = $isDailyRate ? ($price * 7) : ceil($price / 4);
                                                @endphp
                                                Rp {{ number_format($weeklyPrice, 0, ',', '.') }}
                                            </div>
                                        </label>
                                        @endif

                                        {{-- Monthly Option (Only for >= 30 days) --}}
                                        @if($duration >= 30)
                                        <label class="cursor-pointer border-2 rounded-xl p-4 transition-all hover:border-orange-300 relative"
                                            :class="{ 'border-orange-500 bg-orange-50': selected === 'monthly', 'border-gray-200': selected !== 'monthly' }">
                                            <input type="radio" name="billing_cycle" value="monthly" class="sr-only" x-model="selected">
                                            <div class="font-bold text-gray-900">Bulanan</div>
                                            <div class="text-sm text-gray-500">Bayar per bulan</div>
                                            <div class="mt-2 font-bold text-orange-600">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </div>
                                        </label>
                                        @endif

                                        {{-- Full Option (Always Available) --}}
                                        <label class="cursor-pointer border-2 rounded-xl p-4 transition-all hover:border-orange-300 relative"
                                            :class="{ 'border-orange-500 bg-orange-50': selected === 'full', 'border-gray-200': selected !== 'full' }">
                                            <input type="radio" name="billing_cycle" value="full" class="sr-only" x-model="selected">
                                            <div class="font-bold text-gray-900">Lunas ({{ $package->duration_string ?? $duration . ' Hari' }})</div>
                                            <div class="text-sm text-gray-500">Bayar langsung</div>
                                            <div class="mt-2 font-bold text-green-600">
                                                @php
                                                    if ($isDailyRate) {
                                                        $fullPrice = $price * $duration;
                                                    } else {
                                                        $months = ceil($duration / 30);
                                                        $fullPrice = $price * ($months > 0 ? $months : 1);
                                                    }
                                                @endphp
                                                Rp {{ number_format($fullPrice, 0, ',', '.') }}
                                            </div>
                                        </label>

                                    </div>
                                    <x-inputs.error :messages="$errors->get('billing_cycle')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-orange-500 text-white font-bold rounded-xl shadow-lg hover:bg-orange-600 transition">
                                    Lanjut ke Pembayaran &rarr;
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right: Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Paket</h3>
                        
                        <div class="flex items-start gap-4 mb-6">
                            <div class="bg-orange-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $package->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $package->category ?? 'General' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm text-gray-600 mb-6 border-b border-gray-100 pb-4">
                            <div class="flex justify-between">
                                <span>Durasi</span>
                                <span class="font-bold">{{ $package->duration_string }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span>Sesi</span>
                                <span class="font-bold">{{ $package->session_count ?? 4 }} Sesi / Minggu</span>
                            </div>
                        </div>

                        <p class="text-xs text-center text-gray-400">
                            Dengan mendaftar, Anda menyetujui Syarat & Ketentuan L-G Learning.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-landing-layout>
