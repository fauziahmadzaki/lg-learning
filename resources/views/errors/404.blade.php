<x-landing-layout title="Halaman Tidak Ditemukan">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 relative overflow-hidden">
        {{-- Background Decorations --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-100 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-yellow-100 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        </div>

        <div class="relative z-10 text-center px-4">
            {{-- 404 Illustration --}}
            <div class="mb-8 relative inline-block">
                <h1 class="text-[150px] md:text-[200px] font-black text-gray-900 leading-none tracking-tighter opacity-10 select-none">
                    404
                </h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full p-6 shadow-2xl animate-bounce-slow">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                Oops! Halaman Hilang
            </h2>
            <p class="text-lg text-gray-500 mb-8 max-w-md mx-auto">
                Sepertinya kamu tersesat. Halaman yang kamu cari mungkin sudah dipindah atau tidak pernah ada.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 transition transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('contact.index') }}" class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border border-gray-200 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Lapor Masalah
                </a>
            </div>
        </div>
    </div>
</x-landing-layout>
