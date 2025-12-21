<x-landing-layout :settings="$settings" title="Tim Pengajar">

    <div class="h-20 bg-white"></div>

    {{-- PAGE HEADER --}}
    <section class="bg-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Tim Pengajar Kami</h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Berkenalan dengan tutor-tutor berpengalaman yang siap membantu putra-putri Anda meraih prestasi terbaik.
            </p>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($tutors as $tutor)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

                    {{-- Badge Cabang (Pojok Kanan Atas) --}}
                    <div class="absolute top-2 right-2 z-10">
                        @if($tutor->branch)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-white/90 backdrop-blur border border-green-200 text-green-700 shadow-sm">
                            📍 {{ $tutor->branch->name }}
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 border border-gray-200 text-gray-500">
                            Non-Cabang
                        </span>
                        @endif
                    </div>

                    {{-- Bagian Atas: Profil --}}
                    <div class="p-6 pb-2">
                        <div class="flex items-center gap-5">
                            {{-- Avatar --}}
                            <div class="relative">
                                @if($tutor->image)
                                <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md group-hover:scale-105 transition duration-500"
                                    src="{{ asset('storage/' . $tutor->image) }}" alt="{{ $tutor->user->name }}">
                                @else
                                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl border-4 border-white shadow-md">
                                    {{ substr($tutor->user->name, 0, 1) }}
                                </div>
                                @endif
                            </div>

                            {{-- Info Nama --}}
                            <div class="flex-1 min-w-0 pt-2">
                                <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-indigo-600 transition">
                                    {{ $tutor->user->name }}
                                </h3>
                                <div class="flex flex-col gap-1 mt-1">
                                    <span class="flex items-center text-xs text-gray-500">
                                        Professional Tutor
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Separator --}}
                    <div class="px-6 py-2">
                        <div class="border-t border-gray-100"></div>
                    </div>

                    {{-- Bagian Tengah: Bio & Jobs --}}
                    <div class="px-6 pb-6 flex-1 flex flex-col">
                        {{-- Bio --}}
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                                {{ $tutor->bio ?? 'Tutor berdedikasi tinggi dengan pengalaman mengajar yang luas dan metode penyampaian yang menyenangkan.' }}
                            </p>
                        </div>

                        {{-- Tags Keahlian --}}
                        <div class="mt-auto">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pekerjaan</p>
                            <div class="flex flex-wrap gap-2">
                                @if($tutor->jobs && count($tutor->jobs) > 0)
                                    @foreach($tutor->jobs as $job)
                                        @if($loop->index < 4) 
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $job }}
                                            </span>
                                        @endif
                                    @endforeach
                                    @if(count($tutor->jobs) > 4)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-500 border border-gray-200 border-dashed">
                                            +{{ count($tutor->jobs) - 4 }} lainnya
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $tutors->links() }}
            </div>

        </div>
    </section>

</x-landing-layout>
