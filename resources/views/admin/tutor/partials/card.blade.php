@props(['tutor'])

<div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">

    {{-- Badge Cabang (Pojok Kanan Atas) --}}
    <div class="absolute top-2 right-2 z-10">
        @if($tutor->branch)
        <span
            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-white/90 backdrop-blur border border-green-200 text-green-700 shadow-sm">
            📍 {{ $tutor->branch->name }}
        </span>
        @else
        <span
            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 border border-gray-200 text-gray-500">
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
                <div
                    class="h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl border-4 border-white shadow-md">
                    {{ substr($tutor->user->name, 0, 1) }}
                </div>
                @endif

                {{-- Status Dot (Hiasan Visual Active) --}}
                <span
                    class="absolute bottom-1 right-1 block h-4 w-4 rounded-full bg-green-400 ring-2 ring-white"
                    title="Active"></span>
            </div>

            {{-- Info Nama --}}
            <div class="flex-1 min-w-0 pt-2">
                <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-indigo-600 transition">
                    {{ $tutor->user->name }}
                </h3>
                <div class="flex flex-col gap-1 mt-1">
                    <span class="flex items-center text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $tutor->user->email }}
                    </span>
                    @if($tutor->phone)
                    <span class="flex items-center text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        {{ $tutor->phone }}
                    </span>
                    @endif
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
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ $tutor->bio ?? 'Tutor ini belum menambahkan biografi singkat.' }}
            </p>
        </div>

        {{-- Tags Keahlian --}}
        <div class="mt-auto">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pekerjaan
            </p>
            <div class="flex flex-wrap gap-2">
                @if($tutor->jobs && count($tutor->jobs) > 0)
                @foreach($tutor->jobs as $job)
                @if($loop->index < 3) <span
                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $job }}
                    </span>
                    @endif
                    @endforeach
                    @if(count($tutor->jobs) > 3)
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-500 border border-gray-200 border-dashed">
                        +{{ count($tutor->jobs) - 3 }} lainnya
                    </span>
                    @endif
                    @else
                    <span class="text-xs text-gray-400 italic">Belum ada data</span>
                    @endif
            </div>
        </div>
    </div>

    {{-- Footer: Actions --}}
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
        <div class="text-xs text-gray-400 font-medium">
            ID: #{{ $tutor->id }}
        </div>

        <div class="flex items-center gap-2">
            {{-- Detail Button (NEW) --}}
            <a href="{{ route('admin.tutors.show', $tutor) }}"
                class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition"
                title="Lihat Detail">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>

            {{-- Edit Button --}}
            <a href="{{ route('admin.tutors.edit', $tutor) }}"
                class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                title="Edit Data">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </a>

            {{-- Delete Button (Trigger Modal) --}}
            <button
                x-on:click.prevent="deleteUrl = '{{ route('admin.tutors.destroy', $tutor) }}'; tutorName = '{{ addslashes($tutor->user->name) }}'; $dispatch('open-modal', 'confirm-tutor-deletion')"
                class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition"
                title="Hapus Data">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>
