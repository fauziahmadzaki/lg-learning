@php
    $breadcrumbs = [
        'Dashboard' => route('branch.dashboard', $branch),
        'Profil Saya' => null,
    ];
@endphp

<x-app-layout :breadcrumbs="$breadcrumbs">
    <x-slot name="pageTitle">Profil Saya - {{ $tutor->user->name }}</x-slot>

    <div class="space-y-6">
        
        {{-- Header Profil --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
            <div class="px-6 pb-6">
                <div class="relative flex justify-between items-end -mt-12 mb-4">
                    <div class="flex items-end gap-5">
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 overflow-hidden shadow-md">
                            @if($tutor->image)
                                <img src="{{ asset('storage/' . $tutor->image) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($tutor->user->name) }}&background=random&color=fff&size=128" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="mb-2">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $tutor->user->name }}</h2>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @if($tutor->jobs)
                                    @foreach($tutor->jobs as $job)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $job }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                    {{-- Kolom Kiri: Info Kontak & Bio --}}
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Informasi Kontak</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm text-gray-600">{{ $tutor->user->email }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="text-sm text-gray-600">{{ $tutor->phone ?? '-' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-sm text-gray-600">{{ $tutor->address ?? '-' }}</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-sm text-gray-600">
                                        Cabang: <span class="font-bold text-gray-800">{{ $tutor->branch->name ?? 'Semua Cabang' }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        
                        @if($tutor->bio)
                        <div class="mt-6">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tentang {{ explode(' ', $tutor->user->name)[0] }}</h3>
                            <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100">
                                {{ $tutor->bio }}
                            </p>
                        </div>
                        @endif
                    </div>

                    {{-- Kolom Kanan: Paket yang Diammpu --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kelas / Paket yang Diampu</h3>
                            <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full font-bold">{{ $tutor->packages->count() }} Paket</span>
                        </div>
                        
                        @if($tutor->packages->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($tutor->packages as $package)
                                    <a href="{{ route('branch.courses.show', [$branch, $package]) }}" class="block group">
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 hover:shadow-md transition bg-white h-full flex flex-col">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-bold text-gray-800 text-sm group-hover:text-indigo-600 transition">{{ $package->name }}</h4>
                                                @if($package->branch)
                                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">{{ $package->branch->name }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500 mt-auto pt-2 border-t border-gray-50">
                                                {{ $package->grade ?? 'Umum' }} &bull; {{ $package->session_count }} Sesi
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-8 text-center">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <p class="text-sm text-gray-500">Belum ada paket yang ditambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
