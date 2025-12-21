    {{-- TUTORS SECTION (Simple) --}}
    <section class="py-20 bg-white" x-data="{ shown: false }" x-intersect.threshold.10.once="shown = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-700 ease-out transform"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-20'">
            <div class="text-center mb-16">
                <span class="text-orange-500 font-bold tracking-wider uppercase text-sm">Tim Pengajar</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2 sm:text-4xl text-center">Tutor Berpengalaman</h2>
                <div class="mt-4 flex justify-center">
                    <a href="{{ route('tutors.index') }}" class="text-orange-600 font-semibold hover:text-orange-700 flex items-center gap-1">
                        Lihat Semua Tutor <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($tutors as $tutor)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-lg transition group">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        @if($tutor->image)
                            <img src="{{ asset('storage/'.$tutor->image) }}" 
                                 alt="{{ $tutor->user->name }}" 
                                 class="w-full h-full object-cover rounded-full border-4 border-orange-50 group-hover:border-orange-200 transition duration-300"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128';">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128" 
                                 alt="{{ $tutor->user->name }}" 
                                 class="w-full h-full object-cover rounded-full border-4 border-orange-50 group-hover:border-orange-200 transition duration-300">
                        @endif
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-1 group-hover:text-orange-600 transition">{{ $tutor->user->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $tutor->jobs[0] ?? 'Tutor' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
