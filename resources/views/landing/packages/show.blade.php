<x-landing-layout :title="$package->name">

    {{-- HEADER (Bumb) --}}
    <div class="h-20 bg-white"></div>

    {{-- HERO SECTION --}}
    <section class="relative pt-12 pb-20 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-start">
                
                {{-- Left: Details --}}
                <div class="flex-1">
                    {{-- Badge & Title --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 font-bold text-xs uppercase tracking-wider">
                            {{ $package->category ?? 'Paket Belajar' }}
                        </div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-600 font-bold text-xs uppercase tracking-wider">
                            Cabang: {{ $package->branch->name ?? 'Pusat / Online' }}
                        </div>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                        {{ $package->name }}
                    </h1>

                    {{-- Image (If available) --}}
                    @if($package->image)
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-lg h-64 lg:h-80 w-full relative">
                         <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    <p class="text-xl text-gray-500 mb-8 leading-relaxed">
                        {{ $package->description ?? 'Paket belajar intensif untuk membantu siswa mencapai potensi akademik terbaiknya.' }}
                    </p>

                    <div class="flex items-center gap-8 mb-8 text-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                            <span class="font-medium">{{ $package->duration_string }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-purple-100 text-purple-600 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></span>
                            <span class="font-medium">{{ $package->session_count ?? 4 }} Sesi / Minggu</span>
                        </div>
                    </div>

                    {{-- Benefits List --}}
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Fasilitas & Keunggulan</h3>
                        <ul class="space-y-4">
                            @if($package->benefits)
                                @foreach($package->benefits as $benefit)
                                <li class="flex items-start gap-4 p-4 rounded-xl hover:bg-orange-50 transition border border-transparent hover:border-orange-100">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 mt-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <span class="text-gray-900 font-bold block mb-1">Benefit #{{ $loop->iteration }}</span>
                                        <span class="text-gray-600 text-sm">{{ $benefit }}</span>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li class="text-gray-400 italic">Fasilitas standar premium tersedia.</li>
                            @endif
                        </ul>
                    </div>

                    {{-- Mentors / Tutors Section --}}
                    @if($package->tutors->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Mentor Berpengalaman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($package->tutors as $tutor)
                            <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                                    @if($tutor->image)
                                        <img src="{{ asset('storage/' . $tutor->image) }}" 
                                             alt="{{ $tutor->user->name }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128';">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128" 
                                             alt="{{ $tutor->user->name }}" 
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $tutor->user->name }}</h4>
                                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wide">{{ $tutor->subject ?? 'Pengajar Ahli' }}</p>
                                    <p class="text-xs text-gray-500 line-clamp-1 mt-1">{{ $tutor->bio ?? 'Berpengalaman mengajar lebih dari 5 tahun.' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Right: Sidebar / Payment Card --}}
                <div class="w-full lg:w-1/3 sticky top-28">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="p-8">
                            <div class="mb-2 text-sm text-gray-500 font-medium uppercase tracking-wide">Mulai Dari</div>
                            <div class="flex items-end gap-2 mb-6">
                                <span class="text-4xl font-extrabold text-gray-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                <span class="text-gray-500 mb-1">/ bulan</span>
                            </div>
                            
                            <hr class="border-gray-100 mb-6">

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Durasi Belajar</span>
                                    <span class="font-bold text-gray-900">{{ $package->duration_string }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Total Sesi</span>
                                    <span class="font-bold text-gray-900">{{ ($package->session_count ?? 4) * 4 }} Sesi</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Cabang</span>
                                    <span class="font-bold text-gray-900">{{ $package->branch->name ?? '-' }}</span>
                                </div>
                            </div>

                            <a href="{{ route('packages.register', $package->slug ?? $package->id) }}" class="block w-full py-4 bg-orange-500 text-white font-bold rounded-xl text-center shadow-lg shadow-orange-200 hover:bg-orange-600 hover:scale-[1.02] transition-all duration-300">
                                Daftar Sekarang
                            </a>

                            <p class="mt-4 text-xs text-center text-gray-400">
                                Pembayaran aman & mudah via Xendit. <br> Bisa dicicil mingguan atau bulanan.
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                            <p class="text-xs text-gray-500 flex items-center justify-center gap-1">
                                🔒 Garansi Uang Kembali 30 Hari
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-landing-layout>
