<x-landing-layout title="Paket Belajar">

    <div class="h-20 bg-white"></div>

    {{-- PAGE HEADER --}}
    <section class="bg-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Temukan Paket Belajar Terbaik</h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Pilih program bimbingan belajar yang sesuai dengan jenjang pendidikan dan kebutuhan putra-putri Anda.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT (Filter & Grid) --}}
    <section class="py-16 bg-white min-h-screen" 
             x-data="{ 
                search: '', 
                selectedGrade: 'Semua', 
                selectedBranch: 'Semua', 
                selectedType: 'Semua',
                limit: 6,
                packages: {{ $packages->map(fn($p) => [
                    'id' => $p->id,
                    'slug' => $p->slug,
                    'name' => $p->name,
                    'description' => $p->description,
                    'price' => $p->price,
                    'price_formatted' => number_format($p->price, 0, ',', '.'),
                    'grade' => $p->packageCategory->name ?? 'Umum',
                    'category' => $p->category,
                    'branch_id' => $p->branch_id,
                    'branch_name' => $p->branch->name ?? '',
                    'benefits' => $p->benefits,
                    'image' => $p->image_url,
                    'url' => route('packages.show', $p->slug ?? $p->id),
                    'register_url' => route('packages.register', $p->slug ?? $p->id)
                ]) }},
                
                get filteredPackages() {
                    return this.packages.filter(pkg => 
                        (this.selectedGrade === 'Semua' || pkg.grade === this.selectedGrade) && 
                        (this.selectedBranch === 'Semua' || pkg.branch_name === this.selectedBranch) &&
                        (this.selectedType === 'Semua' || pkg.category === this.selectedType) &&
                        (pkg.name.toLowerCase().includes(this.search.toLowerCase()))
                    );
                },

                get visiblePackages() {
                    return this.filteredPackages.slice(0, this.limit);
                }
             }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- FILTERS --}}
            <div class="mb-12 space-y-6">
                
                {{-- Top Row: Search & Dropdowns --}}
                <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                    {{-- Search --}}
                    <div class="relative w-full md:w-96">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" x-model.debounce.500ms="search" placeholder="Cari nama paket..." 
                               class="pl-10 block w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition shadow-sm placeholder-gray-400">
                    </div>

                    {{-- Dropdowns --}}
                    <div class="flex gap-4 w-full md:w-auto">
                        <select x-model="selectedBranch" class="rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 text-sm w-1/2 md:w-auto">
                            <option value="Semua">Semua Cabang</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <select x-model="selectedType" class="rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 text-sm w-1/2 md:w-auto">
                            <option value="Semua">Semua Tipe</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tabs (Grade) --}}
                <div class="flex flex-wrap justify-center gap-2">
                    <button @click="selectedGrade = 'Semua'; limit = 6" 
                            :class="{ 'bg-orange-500 text-white shadow-orange-200 ring-2 ring-orange-500 ring-offset-2': selectedGrade === 'Semua', 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200': selectedGrade !== 'Semua' }"
                            class="px-6 py-2 rounded-full font-medium text-sm transition-all shadow-sm">
                        Semua
                    </button>
                    @foreach($grades as $grade)
                        <button @click="selectedGrade = '{{ $grade }}'; limit = 6" 
                                :class="{ 'bg-orange-500 text-white shadow-orange-200 ring-2 ring-orange-500 ring-offset-2': selectedGrade === '{{ $grade }}', 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200': selectedGrade !== '{{ $grade }}' }"
                                class="px-6 py-2 rounded-full font-medium text-sm transition-all shadow-sm">
                            {{ $grade }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <template x-for="pkg in visiblePackages" :key="pkg.id">
                    <div x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col h-full">
                        
                        {{-- Image --}}
                        <div class="h-48 overflow-hidden relative group">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition duration-300"></div>
                            <img :src="pkg.image" :alt="pkg.name" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                            
                            {{-- Category Badge Overlay --}}
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span x-text="pkg.category" class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-orange-600 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm"></span>
                                <span x-text="pkg.grade" class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-blue-600 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm"></span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 pb-0 flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <span x-text="pkg.branch_name" class="text-xs text-gray-400 font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span x-text="pkg.branch_name"></span>
                                </span>
                            </div>
                            
                            <h3 x-text="pkg.name" class="text-xl font-bold text-gray-900 mb-2"></h3>
                            <p x-text="pkg.description" class="text-sm text-gray-500 line-clamp-2 mb-6"></p>
                            
                            <div class="flex items-baseline mb-6">
                                <span class="text-lg font-bold text-gray-900">Rp </span>
                                <span x-text="pkg.price_formatted" class="text-3xl font-extrabold text-gray-900 ml-1"></span>
                                <span class="text-gray-400 text-sm ml-2">/ bulan</span>
                            </div>

                            <ul class="space-y-3 mb-6">
                                <template x-for="(benefit, idx) in (pkg.benefits ? pkg.benefits.slice(0, 3) : [])" :key="idx">
                                    <li class="flex items-start text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span x-text="benefit"></span>
                                    </li>
                                </template>
                                {{-- Show '...and more' if > 3 benefits --}}
                                <li x-show="pkg.benefits && pkg.benefits.length > 3" class="text-xs text-gray-400 italic pl-7">
                                    +<span x-text="pkg.benefits.length - 3"></span> fasilitas lainnya
                                </li>
                            </ul>
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-6 pt-0 mt-auto flex gap-3">
                            <a :href="pkg.url" class="flex-1 py-3 px-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl text-center hover:bg-gray-50 transition text-sm">
                                Detail
                            </a>
                            <a :href="pkg.register_url" class="flex-1 py-3 px-4 bg-orange-500 text-white font-bold rounded-xl text-center hover:bg-orange-600 shadow-md shadow-orange-200 transition text-sm">
                                Daftar
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Load More Button --}}
            <div x-show="filteredPackages.length > limit" class="text-center pb-12">
                <button @click="limit += 6" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl shadow-sm hover:bg-gray-50 hover:text-orange-600 transition">
                    Lebih Banyak
                </button>
            </div>

            {{-- Empty State --}}
            <div x-show="filteredPackages.length === 0" 
                 class="text-center py-20" style="display: none;">
                <div class="bg-orange-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Tidak ada paket ditemukan</h3>
                <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <button @click="selectedGrade='Semua'; selectedBranch='Semua'; selectedType='Semua'; search=''" class="mt-4 text-orange-600 font-bold hover:underline">Reset Filter</button>
            </div>


        </div>
    </section>

</x-landing-layout>
