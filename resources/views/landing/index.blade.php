<x-landing-layout :settings="$settings">

    {{-- HERO SECTION --}}
    <section id="home" class="relative pt-28 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        
        {{-- Blobs --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-yellow-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-orange-100 rounded-full blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                {{-- Text Content --}}
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 text-orange-600 font-semibold text-sm mb-6">
                        <span class="flex h-2 w-2 rounded-full bg-orange-500"></span>
                        Bimbel Paling Favorit & Terpercaya
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                        {{ $settings['hero_title'] ?? 'Raih Prestasi Gemilang Bersama LG Learning' }}
                    </h1>
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $settings['hero_description'] ?? 'Kami menyediakan bimbingan belajar terbaik dengan metode personal yang disesuaikan dengan kebutuhan setiap siswa.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="/paket" class="px-8 py-4 rounded-xl bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-bold shadow-xl shadow-orange-200 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            {{ $settings['hero_button_text'] ?? 'Pilih Paket Belajar' }}
                        </a>
                        <a href="#about" class="px-8 py-4 rounded-xl bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 hover:border-gray-300 transition-all duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    
                    {{-- Social Proof --}}
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-4 text-sm text-gray-500 font-medium">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-300 border-2 border-white"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-400 border-2 border-white"></div>
                        </div>
                        <p>Dipercaya oleh <span class="text-gray-900 font-bold">{{ $stats['students'] }}+ Siswa</span></p>
                    </div>
                </div>

                {{-- Image Illustration --}}
                <div class="flex-1 relative">
                    <div class="relative z-10 bg-gradient-to-br from-orange-100 to-yellow-50 rounded-3xl p-4 rotate-3 transform hover:rotate-0 transition duration-500">
                        <img src="{{ isset($settings['hero_image']) ? (str_contains($settings['hero_image'], 'http') ? $settings['hero_image'] : asset('storage/' . $settings['hero_image'])) : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80' }}" alt="Students Learning" class="rounded-2xl shadow-lg w-full object-cover h-[500px]">
                        
                        {{-- Floating Badge --}}
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-3 animate-bounce" style="animation-duration: 3s;">
                            <div class="bg-green-100 p-2 rounded-full text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">{{ $settings['hero_badge_title'] ?? 'Hasil Terjamin' }}</p>
                                <p class="text-lg font-bold text-gray-800">{{ $settings['hero_badge_subtitle'] ?? 'Nilai Naik' }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative Elements --}}
                    <div class="absolute top-10 -right-10 text-yellow-400 text-6xl opacity-50 animate-pulse">✨</div>
                    <div class="absolute bottom-20 -right-5 w-24 h-24 bg-orange-500 rounded-full opacity-10 blur-xl"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-12 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
                <div class="space-y-2">
                    <div class="text-4xl font-extrabold text-orange-500">{{ $stats['students'] }}</div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Siswa Aktif</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl font-extrabold text-yellow-500">{{ $stats['tutors'] }}</div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tutor Berpengalaman</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl font-extrabold text-indigo-500">{{ $stats['branches'] }}</div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Cabang Tersebar</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl font-extrabold text-green-500">{{ $stats['packages'] }}</div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pilihan Paket</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT SECTION --}}
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-orange-500 font-bold tracking-wider uppercase text-sm">Tentang Kami</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2 sm:text-4xl">{{ $settings['about_title'] ?? 'Mengapa Memilih LG Learning?' }}</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">{{ $settings['about_description'] ?? 'Kami bukan sekadar bimbel biasa. Kami adalah partner sukses akademik Anda.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $settings['feature_1_title'] ?? 'Metode Personal' }}</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings['feature_1_desc'] ?? 'Setiap anak unik. Kami menyesuaikan pendekatan belajar sesuai dengan gaya dan kecepatan belajar siswa.' }}
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $settings['feature_2_title'] ?? 'Tutor Selektif' }}</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings['feature_2_desc'] ?? 'Tutor kami tidak hanya pintar akademis, tapi juga sabar dan mampu memotivasi siswa untuk berprestasi.' }}
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $settings['feature_3_title'] ?? 'Laporan Berkala' }}</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings['feature_3_desc'] ?? 'Pantau perkembangan anak Anda dengan laporan progress yang detail dan transparan setiap bulannya.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- PACKAGES SECTION --}}
    <section id="packages" class="py-20 bg-orange-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-orange-500 font-bold tracking-wider uppercase text-sm">Paket Belajar</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2 sm:text-4xl">Pilih Paket Sesuai Kebutuhan</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Investasi terbaik untuk masa depan buah hati Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($packages->take(3) as $package)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col h-full">
                    
                    {{-- Image --}}
                    <div class="h-48 overflow-hidden relative group">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition duration-300"></div>
                        <img src="{{ $package->image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        
                        {{-- Category Badge Overlay --}}
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-orange-600 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">{{ $package->category }}</span>
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-blue-600 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">{{ $package->grade }}</span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6 pb-0 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs text-gray-400 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $package->branch->name ?? 'Semua Cabang' }}</span>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $package->name }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-6">{{ $package->description ?? 'Paket belajar intensif dengan materi lengkap.' }}</p>
                        
                        <div class="flex items-baseline mb-6">
                            <span class="text-lg font-bold text-gray-900">Rp </span>
                            <span class="text-3xl font-extrabold text-gray-900 ml-1">{{ number_format($package->price, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-sm ml-2">/ bulan</span>
                        </div>

                        <ul class="space-y-3 mb-6">
                            @if($package->benefits)
                                @foreach(array_slice($package->benefits, 0, 3) as $benefit)
                                <li class="flex items-start text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>{{ $benefit }}</span>
                                </li>
                                @endforeach
                                @if(count($package->benefits) > 3)
                                <li class="text-xs text-gray-400 italic pl-7">
                                    +{{ count($package->benefits) - 3 }} fasilitas lainnya
                                </li>
                                @endif
                            @else
                                <li class="text-gray-400 italic text-sm">Fasilitas lengkap standar premium</li>
                            @endif
                        </ul>
                    </div>

                    {{-- Card Footer --}}
                    <div class="p-6 pt-0 mt-auto flex gap-3">
                        <a href="{{ route('packages.show', $package->slug ?? $package->id) }}" class="flex-1 py-3 px-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl text-center hover:bg-gray-50 transition text-sm">
                            Detail
                        </a>
                        <a href="{{ route('packages.register', $package->slug ?? $package->id) }}" class="flex-1 py-3 px-4 bg-orange-500 text-white font-bold rounded-xl text-center hover:bg-orange-600 shadow-md shadow-orange-200 transition text-sm">
                            Daftar
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('packages.index') }}" class="text-orange-600 font-bold hover:underline">Lihat Semua Paket &rarr;</a>
            </div>
        </div>
    </section>

    @include('landing.partials.simple_tutor_section')

    {{-- GALLERY / ACTIVITIES CAROUSEL SECTION --}}
    <section id="gallery" class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-orange-500 font-bold tracking-wider uppercase text-sm">Galeri & Testimoni</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2 sm:text-4xl">Keseruan Belajar di LG Learning</h2>
            </div>

            <div x-data="{ 
                    activeSlide: 0,
                    slides: {{ json_encode($carousel_slides) }},
                    next() {
                        this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                    },
                    prev() {
                        this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1;
                    }
                }" 
                x-init="setInterval(() => next(), 5000)"
                class="relative">
                
                {{-- Carousel Wrapper --}}
                <div class="relative max-w-5xl mx-auto h-[500px] rounded-3xl overflow-hidden shadow-2xl">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                             x-transition:enter="transition transform duration-700 ease-out"
                             x-transition:enter-start="opacity-0 translate-x-full"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition transform duration-700 ease-in"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-full"
                             class="absolute inset-0 w-full h-full">
                            
                            {{-- Image --}}
                            <img :src="slide.image" class="w-full h-full object-cover brightness-50">
                            
                            {{-- Content Overlay --}}
                            <div class="absolute inset-x-0 bottom-0 p-8 md:p-16 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
                                <div class="max-w-3xl mx-auto text-center transform transition-all duration-500"
                                     x-show="activeSlide === index"
                                     x-transition:enter="delay-300 opacity-0 translate-y-10"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    <span x-text="slide.type" class="inline-block py-1 px-3 rounded-full bg-orange-500 text-white text-xs font-bold mb-4 uppercase tracking-wider"></span>
                                    <h3 x-text="slide.title" class="text-3xl md:text-5xl font-bold text-white mb-4"></h3>
                                    <p x-text="slide.description" class="text-lg md:text-xl text-gray-200 leading-relaxed"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Navigation Buttons --}}
                    <button @click="prev()" class="absolute z-10 top-1/2 left-4 md:left-8 -translate-y-1/2 w-12 h-12 rounded-full bg-white/20 backdrop-blur-md hover:bg-orange-500 text-white flex items-center justify-center transition hover:scale-110 focus:outline-none shadow-lg border border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="next()" class="absolute z-10 top-1/2 right-4 md:right-8 -translate-y-1/2 w-12 h-12 rounded-full bg-white/20 backdrop-blur-md hover:bg-orange-500 text-white flex items-center justify-center transition hover:scale-110 focus:outline-none shadow-lg border border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                {{-- Indicators --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                :class="{ 'bg-orange-500 w-8': activeSlide === index, 'bg-white/50 hover:bg-white w-2': activeSlide !== index }"
                                class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </div>

    {{-- CTA SECTION --}}
        <section class="py-20 relative overflow-hidden mt-20">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-yellow-500"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">Siap Memulai Perjalanan Sukses?</h2>
            <p class="text-xl text-orange-100 mb-10 max-w-2xl mx-auto">
                Jangan tunda prestasi anak Anda. Bergabunglah dengan ratusan siswa lainnya yang telah merasakan manfaat belajar di LG Learning.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-orange-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition transform hover:scale-105">
                    Daftar Sekarang
                </a>
                <a href="#contact" class="px-8 py-4 bg-orange-700 bg-opacity-30 text-white font-bold rounded-xl border border-orange-400 hover:bg-opacity-50 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- CONTACT SECTION --}}
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <span class="text-orange-500 font-bold tracking-wider uppercase text-sm">Hubungi Kami</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mt-2 mb-6">Ada Pertanyaan?</h2>
                    <p class="text-gray-500 mb-8 text-lg">
                        Tim kami siap membantu Anda. Silakan hubungi kami melalui kontak di bawah atau kunjungi kantor kami.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Alamat Kantor</h4>
                                <p class="text-gray-500">{{ $settings['contact_address'] ?? 'Jl. Pendidikan No. 123, Jakarta Selatan' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Telepon / WhatsApp</h4>
                                <p class="text-gray-500">{{ $settings['contact_whatsapp'] ?? '0812-3456-7890' }} <br> {{ $settings['contact_email'] ?? 'info@lglearning.com' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8 h-full" x-data="{ activeAccordion: null }">
                    <h3 class="font-bold text-gray-900 text-xl mb-6">Pertanyaan yang Sering Diajukan</h3>
                    
                    <div class="space-y-4">
                        @php
                            $faqs = isset($settings['faq_data']) ? json_decode($settings['faq_data']) : [];
                        @endphp

                        @foreach($faqs as $index => $faq)
                            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}" 
                                        class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-orange-50 transition">
                                    <span>{{ $faq->question }}</span>
                                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" 
                                         :class="{ 'rotate-180': activeAccordion === {{ $index }} }"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="activeAccordion === {{ $index }}" 
                                     x-transition:enter="transition-all ease-out duration-200"
                                     x-transition:enter-start="opacity-0 max-h-0"
                                     x-transition:enter-end="opacity-100 max-h-40"
                                     class="p-4 pt-0 text-gray-500 text-sm leading-relaxed border-t border-gray-50">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-landing-layout>
