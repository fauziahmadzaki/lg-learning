        {{-- SECTION: Grid Cards --}}
        {{-- SECTION: Grid Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($branches as $branch)
            <div
                class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

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
                    
                    {{-- Statistik Grid --}}
                    <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100 bg-gray-50/50">
                        <div class="p-3 text-center">
                            <div class="text-lg font-bold text-indigo-600">{{ $branch->students_count }}</div>
                            <div class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Siswa</div>
                        </div>
                        <div class="p-3 text-center">
                            <div class="text-lg font-bold text-blue-600">{{ $branch->packages_count }}</div>
                            <div class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Paket</div>
                        </div>
                        <div class="p-3 text-center">
                            <div class="text-lg font-bold text-purple-600">{{ $branch->tutors_count }}</div>
                            <div class="text-[10px] uppercase text-gray-500 font-bold tracking-wider">Tutor</div>
                        </div>
                    </div>

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
                <div class="bg-gray-50 px-5 py-4 border-t border-gray-100 flex items-center justify-between gap-3">
                    
                    {{-- CTA Kelola --}}
                    <a href="{{ route('branch.dashboard', $branch) }}" class="flex-1">
                        <x-primary-button class="w-full justify-center !py-2 !text-xs gap-1.5 shadow-indigo-100">
                            Kelola
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </x-primary-button>
                    </a>

                    {{-- Actions (Edit/Delete) --}}
                    <div class="flex items-center gap-2">
                        {{-- Edit Button --}}
                        <a href="{{ route('admin.branches.edit', $branch) }}"
                            class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition"
                            title="Edit Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        {{-- Delete Button --}}
                        <button
                            x-on:click.prevent="deleteUrl = '{{ route('admin.branches.destroy', $branch) }}'; branchName = '{{ addslashes($branch->name) }}'; $dispatch('open-modal', 'confirm-branch-deletion')"
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
            @empty
            <div
                class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-xl border border-dashed border-gray-300">
                <div class="bg-gray-50 p-4 rounded-full mb-3">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada Cabang</h3>
                <p class="text-gray-500 mt-1 mb-6">Tambahkan lokasi cabang bimbel Anda atau coba kata kunci lain.</p>
                <a href="{{ route('admin.branches.create') }}">
                    <x-primary-button>Tambah Cabang</x-primary-button>
                </a>
            </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $branches->links() }}
        </div>
