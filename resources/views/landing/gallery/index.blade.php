<x-landing-layout :settings="$settings">
    
    {{-- Header Section --}}
    <section class="relative pt-32 pb-12 bg-orange-50 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Galeri Kegiatan</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Dokumentasi keseruan dan aktivitas belajar mengajar di LG Learning.
            </p>
        </div>
    </section>

    {{-- Gallery Grid Section --}}
    <section class="py-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Tabs Filter --}}
            <div class="flex justify-center mb-10">
                <div class="bg-gray-100 p-1 rounded-xl inline-flex">
                    <a href="{{ route('gallery.index') }}" 
                       class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ !request('type') ? 'bg-white text-orange-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Semua
                    </a>
                    <a href="{{ route('gallery.index', ['type' => 'Kegiatan']) }}" 
                       class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ request('type') === 'Kegiatan' ? 'bg-white text-orange-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Kegiatan
                    </a>
                    <a href="{{ route('gallery.index', ['type' => 'Testimoni']) }}" 
                       class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ request('type') === 'Testimoni' ? 'bg-white text-orange-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                        Testimoni
                    </a>
                </div>
            </div>

            @if($galleries->isEmpty())
                <div class="text-center py-20 bg-gray-50 rounded-3xl border border-gray-100">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada foto galeri</h3>
                    <p class="mt-2 text-gray-500">Nantikan update kegiatan seru kami selanjutnya!</p>
                </div>
            @else
                {{-- AlpineJS Lightbox --}}
                <div x-data="{ 
                        modalOpen: false,
                        activeImage: '',
                        activeTitle: '',
                        activeDesc: '',
                        openModal(image, title, desc) {
                            this.activeImage = image;
                            this.activeTitle = title;
                            this.activeDesc = desc;
                            this.modalOpen = true;
                        }
                    }">

                    {{-- Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($galleries as $item)
                        <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            {{-- Image Container --}}
                            <div class="aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100 relative cursor-pointer"
                                 @click="openModal('{{ $item->image_url }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}')">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-1 group-hover:text-orange-600 transition">{{ $item->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-2">{{ $item->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Modal Lightbox --}}
                    <div x-show="modalOpen" 
                         style="display: none;"
                         class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        
                        {{-- Backdrop --}}
                        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="modalOpen = false"></div>

                        {{-- Content --}}
                        <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden max-h-[90vh] flex flex-col"
                             x-show="modalOpen"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-90 translate-y-4">
                            
                            {{-- Close Button --}}
                            <button @click="modalOpen = false" class="absolute top-4 right-4 z-10 p-2 bg-black/50 text-white rounded-full hover:bg-black/70 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <div class="flex-1 overflow-auto bg-black flex items-center justify-center p-4">
                                <img :src="activeImage" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
                            </div>
                            
                            <div class="p-6 bg-white border-t border-gray-100">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2" x-text="activeTitle"></h3>
                                <p class="text-gray-600 leading-relaxed" x-text="activeDesc"></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @endif

        </div>
    </section>

</x-landing-layout>
