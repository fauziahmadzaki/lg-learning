{{-- GRID PAKET --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse ($packages as $package)
            <div x-show="activeTab === 'SEMUA' || activeTab == '{{ $package->package_category_id }}'"
        x-transition.opacity.duration.300ms
        class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

        {{-- Gambar Header (Aspect Video Fixed) --}}
        <div class="aspect-video w-full bg-gray-100 relative overflow-hidden">
            @if($package->image)
            <img src="{{ asset('storage/'.$package->image) }}"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
            {{-- Pattern Fallback --}}
            <div
                class="w-full h-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-4xl font-black opacity-80">
                {{ substr($package->name, 0, 1) }}
            </div>
            @endif

            {{-- BADGE KATEGORI --}}
            <div class="absolute top-3 left-3">
                @php $color = $package->badge_color; @endphp
                <span
                    class="bg-{{ $color }}-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wide">
                    {{ $package->category }}
                </span>
            </div>

            {{-- BADGE GRADE --}}
            <div class="absolute bottom-3 left-3">
                <span
                    class="bg-gray-900/60 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded border border-white/20">
                    {{ $package->packageCategory->name ?? 'Umum' }}
                </span>
            </div>

            {{-- Badge Harga --}}
            <div
                class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow text-sm font-bold text-gray-800 border border-white/50">
                Rp {{ number_format($package->price, 0, ',', '.') }}
            </div>
        </div>

        {{-- Body Card --}}
        <div class="pt-5 px-6 pb-2 flex-1 flex flex-col">
            <div class="flex justify-between items-start mb-2">
                <h4
                    class="text-lg font-bold text-gray-900 leading-tight group-hover:text-indigo-600 transition">
                    {{ $package->name }}
                </h4>
            </div>

            {{-- Info Singkat (Branch removed) --}}
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4 border-b border-gray-100 pb-4">
                <span class="flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded text-gray-600">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $package->session_count }} Sesi
                </span>
                <span class="flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded text-gray-600">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    {{ $package->students_count }} Siswa
                </span>
            </div>

            {{-- List Benefit --}}
            <ul class="space-y-2 mb-4 flex-1">
                @if($package->benefits)
                @foreach(array_slice($package->benefits, 0, 3) as $benefit)
                <li class="flex items-start text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $benefit }}
                </li>
                @endforeach
                @if(count($package->benefits) > 3)
                <li class="text-xs text-gray-400 pl-6 font-medium">+ {{ count($package->benefits) - 3 }}
                    keuntungan lainnya</li>
                @endif
                @else
                <li class="text-sm text-gray-400 italic">Belum ada detail benefit</li>
                @endif
            </ul>
        </div>

        {{-- Footer: Actions (Branch Routes) --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">

            {{-- Kiri: ID --}}
            <div class="text-xs text-gray-400 font-medium">
                ID: #{{ $package->id }}
            </div>

            {{-- Kanan: Action Icons --}}
            <div class="flex items-center gap-2">
                {{-- Edit Button --}}
                <a href="{{ route('branch.packages.edit', [$branch, $package]) }}"
                    class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                    title="Edit Paket">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </a>

                {{-- Delete Button (Trigger Modal) --}}
                <button
                    x-on:click.prevent="deleteAction = '{{ route('branch.packages.destroy', [$branch, $package]) }}'; packageName = '{{ addslashes($package->name) }}'; $dispatch('open-modal', 'confirm-package-deletion')"
                    class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                    title="Hapus Paket">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
    @empty
    <div class="col-span-full p-10 text-center bg-white rounded-xl border border-dashed border-gray-300">
        <div class="bg-indigo-50 p-4 rounded-full mb-4 inline-block">
            <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <h3 class="text-gray-900 font-bold text-lg">Belum ada paket tersedia</h3>
        <p class="text-sm text-gray-500 mt-1 mb-6">Silakan tambahkan data paket baru untuk memulai, atau coba kata kunci lain.</p>
        <a href="{{ route('branch.packages.create', $branch) }}">
            <x-buttons.primary>Buat Paket Pertama</x-buttons.primary>
        </a>
    </div>
    @endforelse

</div>
