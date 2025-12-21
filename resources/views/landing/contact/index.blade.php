<x-landing-layout :settings="$settings" title="Hubungi Kami">
    
    {{-- Header Section --}}
    <section class="relative pt-32 pb-12 bg-orange-50 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Lokasi & Kontak</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan cabang L-G Learning terdekat dari lokasi Anda.
            </p>
        </div>
    </section>

    {{-- Branches Grid --}}
    <section class="py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($branches->isEmpty())
                <div class="text-center py-20 bg-gray-50 rounded-3xl border border-gray-100">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada data cabang</h3>
                    <p class="mt-2 text-gray-500">Silakan hubungi kontak utama kami untuk informasi lebih lanjut.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($branches as $branch)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        
                        {{-- Card Header: Visual Placeholder --}}
                        <div class="h-28 bg-gradient-to-r from-blue-600 to-indigo-700 relative overflow-hidden text-white p-6">
                            {{-- Pattern @ Background --}}
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                            
                            {{-- Nama Cabang --}}
                            <div class="relative z-10">
                                <h3 class="text-xl font-bold mb-1 truncate" title="{{ $branch->name }}">{{ $branch->name }}</h3>
                            </div>

                            {{-- Icon Gedung (Decor) --}}
                            <div class="absolute -bottom-4 right-4 opacity-20 transform scale-150 rotate-12">
                                 <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="flex-1 flex flex-col">
                            


                            {{-- Detail Info --}}
                            <div class="p-5 space-y-4">
                                {{-- Alamat --}}
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Alamat</p>
                                        @if($branch->address)
                                            <p class="text-sm text-gray-700 leading-relaxed line-clamp-2">{{ $branch->address }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 italic">Alamat belum ditambahkan</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Kontak --}}
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kontak</p>
                                        @if($branch->phone)
                                            <p class="text-sm text-gray-700 font-medium">{{ $branch->phone }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 italic">Kontak belum ditambahkan</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer: Actions (CTA) --}}
                        <div class="bg-gray-50 px-5 py-4 border-t border-gray-100">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', str_replace(['-', ' '], '', $branch->phone ?? $settings['contact_whatsapp'] ?? '')) }}?text={{ urlencode('Halo Admin ' . $branch->name . ', saya ingin bertanya informasi bimbel.') }}" 
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-md shadow-green-100 transition transform hover:scale-[1.02] text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                                Hubungi Admin
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            {{-- Main Office Fallback --}}
            <div class="mt-16 bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold mb-4">Butuh Bantuan Lainnya?</h2>
                    <p class="text-gray-300 mb-8 max-w-xl mx-auto">Jika Anda tidak menemukan cabang di kota Anda atau memiliki pertanyaan umum, jangan ragu untuk menghubungi layanan pusat kami.</p>
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', str_replace(['-', ' '], '', $settings['contact_whatsapp'] ?? '')) }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-gray-900 font-bold rounded-xl shadow-lg hover:bg-gray-100 transition transform hover:scale-105">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                        Hubungi Admin Pusat
                    </a>
                </div>
            </div>

        </div>
    </section>

</x-landing-layout>
